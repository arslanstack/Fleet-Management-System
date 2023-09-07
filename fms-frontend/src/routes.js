/* eslint-disable import/first */
import React from "react";
import { DataTable, Detail, Manage, } from "./_pages/Authenticated/CRUD";

const Dashboard = React.lazy(() => import("./views/Dashboard"));
import { AdminManage } from "./_pages/Authenticated/Admin/AdminManage";
import { UserCustomNotifications } from "./_pages/Authenticated/UserCustomNotifications/UserCustomNotifications";
import { UserCustomNotification } from "./_pages/Authenticated/UserCustomNotifications/UserCustomNotification";
import { UserCustomNotificationManage } from "./_pages/Authenticated/UserCustomNotifications/UserCustomNotificationManage";
import { DistributeProfit } from "./_pages/Authenticated/DistributeProfit";
import { RideEarnings } from "./_pages/Authenticated/RideEarnings";
import { Users } from "./_pages/Authenticated/Users/Users";


// const Console = React.lazy(() => import("./views/Console"));
const routes = [
  { path: "/admin", exact: true, name: "Home" },
  { path: "/manage", exact: true, name: "Admin Manage", component: AdminManage },
  { path: "/dashboard", name: "Dashboard", component: Dashboard },

  // { path: "/users", exact: true, name: "Users", component: Users },
  // { path: "/user/:id/packages", exact: true, name: "User Packages", component: UserPackages },
  // { path: "/user/filter/:type", exact: true, name: "Filter Users", component: Users },
  // { path: "/users/:id", exact: true, name: "User Details", component: User },
  

  { path: "/users", exact: true, component: Users },
  { path: "/user/add", exact: true, name: "Add Users", component: Manage },
  { path: "/user/edit/:id", exact: true, name: "Edit Users", component: Manage },
  { path: "/users/delete/:id", exact: true, name: "Delete", component: Detail },
  { path: "/users/detail/:id", exact: true, name: "Details", component: Detail },

  { path: "/user-custom-notifications", exact: true, name: "User Custom Notifications", component: UserCustomNotifications },
  { path: "/user-custom-notifications/detail/:id", exact: true, name: "Details", component: UserCustomNotification },
  { path: "/user-custom-notification/add", exact: true, name: "New Custom Notification", component: UserCustomNotificationManage },
  { path: "/user-custom-notification/edit/:id", exact: true, name: "Edit User Custom Notification", component: UserCustomNotificationManage },
  { path: "/user-custom-notifications/delete/:id", exact: true, name: "Delete", component: UserCustomNotification },

  
  { path: "/vehicle-categories", exact: true, component: DataTable },
  { path: "/vehicle-category/add", exact: true, name: "Add Vehicle Category", component: Manage },
  { path: "/vehicle-category/edit/:id", exact: true, name: "Edit Vehicle Category", component: Manage },
  { path: "/vehicle-categories/delete/:id", exact: true, name: "Delete", component: Detail },
  { path: "/vehicle-categories/detail/:id", exact: true, name: "Details", component: Detail },

  { path: "/verification-requests", exact: true, component: DataTable },
  // { path: "/verification-request/add", exact: true, name: "Add Verification Request", component: Manage },
  { path: "/verification-request/edit/:id", exact: true, name: "Edit Verification Request", component: Manage },
  { path: "/verification-requests/delete/:id", exact: true, name: "Delete", component: Detail },
  { path: "/verification-requests/detail/:id", exact: true, name: "Details", component: Detail },

  { path: "/pages", exact: true, component: DataTable },
  { path: "/page/add", exact: true, name: "Add Page", component: Manage },
  { path: "/page/edit/:id", exact: true, name: "Edit Page", component: Manage },
  { path: "/pages/delete/:id", exact: true, name: "Delete", component: Detail },
  { path: "/pages/detail/:id", exact: true, name: "Details", component: Detail },

  { path: "/news-categories", exact: true, component: DataTable },
  { path: "/news-category/add", exact: true, name: "Add News Category", component: Manage },
  { path: "/news-category/edit/:id", exact: true, name: "Edit News Category", component: Manage },
  { path: "/news-categories/delete/:id", exact: true, name: "Delete", component: Detail },
  { path: "/news-categories/detail/:id", exact: true, name: "Details", component: Detail },

  { path: "/news", exact: true, component: DataTable },
  { path: "/news/add", exact: true, name: "Add News", component: Manage },
  { path: "/news/edit/:id", exact: true, name: "Edit News", component: Manage },
  { path: "/news/delete/:id", exact: true, name: "Delete", component: Detail },
  { path: "/news/detail/:id", exact: true, name: "Details", component: Detail },



  { path: "/supportmessages", exact: true, component: DataTable },
  { path: "/supportmessages/delete/:id", exact: true, name: "Delete", component: Detail },
  { path: "/supportmessages/detail/:id", exact: true, name: "Details", component: Detail },


  { path: "/distribute-profit", exact: true, component: DistributeProfit },

  { path: "/ride-earnings", exact: true, component: RideEarnings },


  // { path: '/payment-settings', exact: true, name: 'Payment Settings', component: PaymentSettings },


  { path: "/setting/edit/:id", exact: true, name: "Edit Setting", component: Manage },
  
  { path: "/roles", exact: true, component: DataTable },
  { path: "/role/add", exact: true, name: "Add Role", component: Manage },
  { path: "/role/edit/:id", exact: true, name: "Edit Role", component: Manage },
  { path: "/roles/delete/:id", exact: true, name: "Delete", component: Detail },
  { path: "/roles/detail/:id", exact: true, name: "Details", component: Detail },

  
  { path: "/states", exact: true, component: DataTable },
  { path: "/state/add", exact: true, name: "Add State", component: Manage },
  { path: "/state/edit/:id", exact: true, name: "Edit State", component: Manage },
  { path: "/states/delete/:id", exact: true, name: "Delete", component: Detail },
  { path: "/states/detail/:id", exact: true, name: "Details", component: Detail },

  
  { path: "/state-fares", exact: true, component: DataTable },
  { path: "/state-fare/add", exact: true, name: "Add State Fare", component: Manage },
  { path: "/state-fare/edit/:id", exact: true, name: "Edit State Fare", component: Manage },
  { path: "/state-fares/delete/:id", exact: true, name: "Delete", component: Detail },
  { path: "/state-fares/detail/:id", exact: true, name: "Details", component: Detail },

  { path: "/rides", exact: true, component: DataTable },
  { path: "/ride/add", exact: true, name: "Add Ride", component: Manage },
  { path: "/ride/edit/:id", exact: true, name: "Edit Ride", component: Manage },
  { path: "/rides/delete/:id", exact: true, name: "Delete", component: Detail },
  { path: "/rides/detail/:id", exact: true, name: "Details", component: Detail },

  { path: "/usertransactions", exact: true, component: DataTable },
  { path: "/usertransaction/add", exact: true, name: "Add Transaction", component: Manage },
  { path: "/usertransaction/edit/:id", exact: true, name: "Edit Transaction", component: Manage },
  { path: "/usertransactions/delete/:id", exact: true, name: "Delete", component: Detail },
  { path: "/usertransactions/detail/:id", exact: true, name: "Details", component: Detail },
];

export default routes;
