export default {
  items: [
    {
      name: "Dashboard",
      url: "/dashboard",
      icon: "icon-speedometer",
      badge: {
        variant: "info",
        text: "NEW"
      }
    },
    {
      name: "Vehicle Categories",
      url: "/vehicle-categories",
      icon: "fa fa-car",
      children: [
        {
          name: "Add Vehicle Category",
          url: "/vehicle-category/add",
          icon: "fa fa-plus-circle",
          class: 'ml-2'
        },
        {
          name: "Vehicle Categories",
          url: "/vehicle-categories",
          icon: "fa fa-car",
          class: 'ml-2'
        },
        {
          name: "State Wise Fare",
          url: "/state-fares",
          icon: "fa fa-globe",
          class: 'ml-2'
        }
      ]
    },
    {
      name: "Drivers",
      url: "/drivers",
      icon: "fa fa-user",
      // children: [
      //   {
      //     name: "Riders",
      //     url: "/users?filter={\"role\":\"Rider\"}",
      //     icon: "fa fa-user",
      //     class: 'ml-2'
      //   },
      //   {
      //     name: "Drivers",
      //     url: "/users?filter={\"role\":\"Driver\"}",
      //     icon: "fa fa-user",
      //     class: 'ml-2'
      //   },


      // ]
    },

    {
      name: "Verification Requests",
      url: "/verification-requests",
      icon: "fa fa-lock",
    },

    {
      name: "Rides",
      url: "/rides",
      icon: "fa fa-car",
    },
    
    {
      name: "Ride Earnings",
      url: "/ride-earnings",
      icon: "fa fa-usd",
    },
    {
      name: "Transactions",
      url: "/usertransactions",
      icon: "fa fa-usd",
    },
    {
      name: "Notifications",
      url: "/user-custom-notifications",
      icon: "fa fa-bell",
      children: [
        {
          name: "Add Notification",
          url: "/user-custom-notification/add",
          icon: "fa fa-plus-circle",
          class: 'ml-2'
        },
        {
          name: "Notification List",
          url: "/user-custom-notifications",
          icon: "fa fa-bell",
          class: 'ml-2'
        }
      ]
    },
    {
      name: "News",
      url: "/news",
      icon: "fa fa-newspaper-o",
      children: [
        {
          name: "News Categories",
          url: "/news-categories",
          icon: "fa fa-newspaper-o",
          class: 'ml-2'
        },
        {
          name: "Add News",
          url: "/news/add",
          icon: "fa fa-plus-circle",
          class: 'ml-2'
        },
        {
          name: "News List",
          url: "/news",
          icon: "fa fa-newspaper-o",
          class: 'ml-2'
        }
      ]
    },

    {
      name: "Support",
      url: "/supportmessages",
      icon: "fa fa-life-ring",

    },
    {
      // title: true,
      name: 'Setup',
      url:"/settings",
      icon: 'fa fa-wrench',
      
      children: [
        {
          name: 'Pages',
          url: '/pages',
          icon: 'fa fa-file',
          class: 'ml-2'
        },
        {
          name: 'States',
          url: '/states',
          icon: 'fa fa-globe',
          class: 'ml-2'
        },
        {
          name: 'Roles',
          url: '/roles',
          icon: 'fa fa-user',
          class: 'ml-2'
        },
        {
          name: 'Settings',
          url: '/setting',
          icon: 'fa fa-wrench',
          class: 'ml-2'
        },

      ]
    },


  ]
};
