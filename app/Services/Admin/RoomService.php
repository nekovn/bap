<?php

namespace App\Services\Admin;

use App\Enums\DefaultDefine;
use App\Helpers\Flash;
use App\Helpers\SystemHelper;
use App\Models\Room;
use App\Models\RoomImage;
use App\Repositories\Admin\RoomRepository;
use App\Services\BaseServiceTrait;
use Illuminate\Support\Arr;

class RoomService
{
    use BaseServiceTrait {
        BaseServiceTrait::find as findItem;
        BaseServiceTrait::findByPkey as findByPkeyItem;
        BaseServiceTrait::search as searchItem;
        BaseServiceTrait::getLastRow as getLastRowDate;
    }

    public $repository;

    public function __construct(RoomRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(array $values)
    {
        $utilities = array_merge($values['utility_room'] ?? [], $values['space_room'] ?? [], $values['space_share'] ?? []);
        $result = $this->repository->create($values);
        if ($result) {
            if (isset($values['addFile'])) {
                //ファイルアップロード
                $nameFile = SystemHelper::handleFileUpload($values['addFile']);
                if ($nameFile) {
                    //hasMany(1親ー複数子)ファイルをDBにインサートする
                    $result->image()->createMany($nameFile);
                }
            }
            //(1子ー複数親) with sync(): 重複しない項目インサートする
            //中間テーブルでID存在しない時、インサートする、逆に存在すれば、削除する
            if ($utilities) $result->utilities()->sync($utilities);
        }
        return $result;
    }

    public function delete(array $conditions = [])
    {
        foreach ($conditions['id'] as $id) {
            $roomImg = Room::find($id);
            $images = $roomImg->image()->get()->toArray();
            foreach ($images as $image) {
                Flash::deleteOldImage(DefaultDefine::IMAGE_DISK_PATH, $image['name']);
            }
            //hasMany(1親ー複数子)のテーブル削除
            $roomImg->image()->delete();
            //belongsToMany(1子ー複数親)の中間テーブル削除
            $roomImg->utilities()->detach();
        }
        return $this->repository->delete($conditions);
    }

    public function update(array $values, string $id): bool
    {
        $utilities = array_merge($values['utility_room'] ?? [], $values['space_room'] ?? [], $values['space_share'] ?? []);
        $except = ['utility_room', 'space_room', 'space_share', 'addFile', 'deleteFile'];
        $result = $this->repository->update(Arr::except($values, $except), $id);
        if ($result) {
            $roomImg = Room::find($id);
            //新しいファイル
            if (isset($values['addFile'])) {
                //ファイルアップロード
                $nameFile = SystemHelper::handleFileUpload($values['addFile']);
                if ($nameFile) {
                    //hasMany(1親ー複数子)ファイルをDBにインサートする
                    $roomImg->image()->createMany($nameFile);
                }
            }
            //元ファイル
            if (isset($values['deleteFile'])) {
                //DBからファイルID削除
                if(count($values['deleteFile']['id'])) {
                    $roomImg->image()->whereIn('id', $values['deleteFile']['id'])->delete();
                }
                //ディレクトリからファイル名削除
                if(count($values['deleteFile']['name'])) {
                    foreach ($values['deleteFile']['name'] as $image) {
                        Flash::deleteOldImage(DefaultDefine::IMAGE_DISK_PATH, $image);
                    }
                }
            }
            //(1子ー複数親) with sync(): 重複しない項目インサートする
            //通信すると、毎回更新する。中間テーブルで新しいデータがあれば、インサートする、元データ削除する
            if ($utilities) $roomImg->utilities()->sync($utilities);
        }
        return $result;
    }
}
