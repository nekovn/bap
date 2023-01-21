/**
 * 参照ページ：https://fontawesome.com/icons
 */

/* fontawesome コアをインポートする */
import { library } from '@fortawesome/fontawesome-svg-core'

/* アイコン コンポーネントをインポートする */
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

/* 特定のアイコンをインポートする */
import {
    faCloudSun,
    faCloudMoon,
    faRightToBracket,
    faRightFromBracket,
    faLocationDot,
    faPhoneVolume,
    faEnvelope,
    faHouseUser,
    faCity,
    faPeopleRoof,
    faHandsPraying,
    faComments,
    faEye,
    faEyeSlash,
    faPlus,
    faBug,
    faChartLine,
    faMagnifyingGlass,
    faBackwardFast,
    faBackward,
    faForward,
    faForwardFast,
    faPen,
    faCircleCheck,
    faTrash,
    faTriangleExclamation,
    faIdCard,
    faFloppyDisk,
    faPenToSquare
} from '@fortawesome/free-solid-svg-icons'


/* ライブラリにアイコンを追加する */
library.add(
    faCloudSun,
    faCloudMoon,
    faRightToBracket,
    faRightFromBracket,
    faLocationDot,
    faPhoneVolume,
    faEnvelope,
    faHouseUser,
    faCity,
    faPeopleRoof,
    faHandsPraying,
    faComments,
    faEye,
    faEyeSlash,
    faPlus,
    faBug,
    faChartLine,
    faMagnifyingGlass,
    faBackwardFast,
    faBackward,
    faForward,
    faForwardFast,
    faPen,
    faCircleCheck,
    faTrash,
    faTriangleExclamation,
    faIdCard,
    faFloppyDisk,
    faPenToSquare
)

export default FontAwesomeIcon;
