import {
    HiChartPie,
    HiUser,
    HiCollection,
    HiAdjustments,
    HiPlusCircle,
    HiCurrencyDollar,
    HiCash,
    HiClipboardList,
    HiHashtag,
    HiUsers,
    HiUserGroup,
    HiUserCircle,
    HiOutlineTruck,
    HiDatabase,
    HiShoppingBag,
    HiReceiptTax,
    HiHome,
    HiInboxIn,
    HiOutlineCash,
    HiOutlineTable,
    HiDocument,
    HiCalendar
} from "react-icons/hi";

export default [
    {
        name: "Dashboard",
        show: true,
        icon: HiChartPie,
        route: route("dashboard"),
        active: "dashboard",
        permission: "view-dashboard",
    },
    {
        name: "Master",
        show: true,
        icon: HiDocument,
        items:[
            {
                name: "Divisi",
                show: true,
                icon: HiUserGroup,
                route: route("division.index"),
                active: "divisions.*",
                permission: "view-division",
            },
            {
                name: "Jabatan",
                show: true,
                icon: HiUserCircle,
                route: route("position.index"),
                active: "positions.*",
                permission: "view-position",
            },
            {
                name: "Pegawai",
                show: true,
                icon: HiUsers,
                route: route("employee.index"),
                active: "employees.*",
                permission: "view-employee",
            },
            {
                name: "Jadwal",
                show: true,
                icon: HiCalendar,
                route: route("scheduler.index"),
                active: "schedules.*",
                permission: "view-schedule",
            }
        ] 
    },
    {
        name: "User",
        show: true,
        icon: HiUser,
        items: [
            {
                name: "Roles",
                show: true,
                icon: HiUserGroup,
                route: route("roles.index"),
                active: "roles.*",
                permission: "view-role",
            },
            {
                name: "Users",
                show: true,
                icon: HiUsers,
                route: route("user.index"),
                active: "user.index",
                permission: "view-user",
            },
        ],
    },
];
