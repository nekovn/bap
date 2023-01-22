import {defineAsyncComponent} from "vue";
import {useTable} from "./useTable";

const importComponentPage = () => {
    const Edit = defineAsyncComponent(() => import('@modal-admin/Edit'));
    const Create = defineAsyncComponent(() => import('@modal-admin/Create'));
    const Confirm = defineAsyncComponent(() => import('@modal-admin/Confirm'));
    const ReadyOnly = defineAsyncComponent(() => import('@modal-admin/ReadyOnly'));
    const ShowForm = defineAsyncComponent(() => import('@components/Admin/ShowForm'));
    const ThemeAdmin = defineAsyncComponent(() => import('@themes/Admin/ThemeAdmin'));
    const HeadTag = defineAsyncComponent(() => import('@components/Head/HeadTag'));
    return {Edit, Create, Confirm, ReadyOnly, ShowForm, ThemeAdmin, HeadTag, useTable}
}

const importComponentModalForm = () => {
    const FormGroup = defineAsyncComponent(() => import('@modal-admin-form/FormGroup'));
    const InputElement = defineAsyncComponent(() => import('@modal-admin-form/InputElement'));
    const SelectElement = defineAsyncComponent(() => import('@modal-admin-form/SelectElement'));
    const TextareaElement = defineAsyncComponent(() => import('@modal-admin-form/TextareaElement'));
    const RadioElement = defineAsyncComponent(() => import('@modal-admin-form/RadioElement'));
    const DateElement = defineAsyncComponent(() => import('@modal-admin-form/DateElement'));
    const HiddenElement = defineAsyncComponent(() => import('@modal-admin-form/HiddenElement'));
    const UploadFileElement = defineAsyncComponent(() => import('@modal-admin-form/UploadFileElement'));
    return {FormGroup, InputElement, SelectElement, TextareaElement, RadioElement, DateElement, HiddenElement, UploadFileElement}
}

const importComponentModalArea = () => {
    const ModalFooter = defineAsyncComponent(() => import('@modal-admin-area/ModalFooter'));
    const ModalEmpty = defineAsyncComponent(() => import('@modal-admin-area/ModalEmpty'));
    const ModalHead = defineAsyncComponent(() => import('@modal-admin-area/ModalHead'));
    return {ModalFooter, ModalEmpty, ModalHead}
}

const importComponentModalButton = () => {
    const Close = defineAsyncComponent(() => import('@modal-admin-button/Close'));
    const Save = defineAsyncComponent(() => import('@modal-admin-button/Save'));
    const Edit = defineAsyncComponent(() => import('@modal-admin-button/Edit'));
    return {Close, Save, Edit}
}

const importComponentItem = () => {
    const Search = defineAsyncComponent(() => import('@admin-item/Search'));
    const Thead = defineAsyncComponent(() => import('@admin-item/Thead'));
    const Tbody = defineAsyncComponent(() => import('@admin-item/Tbody'));
    const Pagination = defineAsyncComponent(() => import('@admin-item/Pagination'));
    const Sort = defineAsyncComponent(() => import('@admin-item/Filter/Sort'));
    const Time = defineAsyncComponent(() => import('@admin-item/Filter/Time'));
    const ShowPage = defineAsyncComponent(() => import('@admin-item/Filter/ShowPage'));
    const ButtonFilter = defineAsyncComponent(() => import('@admin-item/Filter/ButtonFilter'));
    return {Search, Thead, Tbody, Pagination, Sort, Time, ShowPage, ButtonFilter}
}

const importComponentTheme = () => {
    const Footer = defineAsyncComponent(() => import('@components/Layouts/Admin/Footer'));
    const Header = defineAsyncComponent(() => import('@components/Layouts/Admin/Header'));
    const Navbar = defineAsyncComponent(() => import('@components/Layouts/Admin/Navbar'));
    const ToastElement = defineAsyncComponent(() => import('@components/Layouts/Toast/ToastElement'));
    const SpinnerElement = defineAsyncComponent(() => import('@components/Layouts/Spiner/SpinnerElement'));
    return {Footer, Header, Navbar, ToastElement, SpinnerElement}
}

const importComponentLayout = () => {
    const NavbarIcon = defineAsyncComponent(() => import('@components/Layouts/Admin/Items/NavbarIcon'));
    const NavbarToggler = defineAsyncComponent(() => import('@components/Layouts/Admin/Items/NavbarToggler'));
    const FooterLeft = defineAsyncComponent(() => import('@components/Layouts/Admin/Items/FooterLeft'));
    const FooterRight = defineAsyncComponent(() => import('@components/Layouts/Admin/Items/FooterRight'));
    const HeaderDelete = defineAsyncComponent(() => import('@components/Layouts/Admin/Button/HeaderDelete'));
    const HeaderCreate = defineAsyncComponent(() => import('@components/Layouts/Admin/Button/HeaderCreate'));
    return {NavbarIcon, NavbarToggler, FooterLeft, FooterRight, HeaderDelete, HeaderCreate}
}


export {
    importComponentPage,
    importComponentModalForm,
    importComponentModalArea,
    importComponentModalButton,
    importComponentItem,
    importComponentTheme,
    importComponentLayout,
}
