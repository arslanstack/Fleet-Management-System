
import { authHeader } from '../_helpers';
import _config from '../_config';
import Axios from 'axios';
import { getStyle } from '@coreui/coreui/dist/js/coreui-utilities'
import { CustomTooltips } from '@coreui/coreui-plugin-chartjs-custom-tooltips';
const brandPrimary = getStyle('--primary')
const brandInfo = getStyle('--info')
export const dashboardService = {
    userCounter: function () {
        const requestOptions = {
            headers: authHeader()
        };
        return Axios.get(`${_config.baseUrl}/api/admin/dashboard/user-counter?dateTime=${new Date().toISOString()}`, requestOptions).then(handleResponse);
    },
    registeredUserGraph: function () {
        const requestOptions = {
            headers: authHeader()
        };
        return Axios.get(`${_config.baseUrl}/api/admin/dashboard/user-registered-graph?dateTime=${new Date().toISOString()}`, requestOptions).then(response => {
            let m = response.data;

            return {
                regiseteredUserCounter: m.data.reduce((a, b) => a + b, 0),
                registeredUserData: {
                    labels: m.labels,
                    datasets: [
                        {
                            label: 'Rider Registered On',
                            backgroundColor: brandInfo,
                            borderColor: 'rgba(255,255,255,.55)',
                            data: m.data,
                        },
                    ],
                },
                registeredUserOptions: {
                    tooltips: {
                        enabled: false,
                        custom: CustomTooltips
                    },
                    maintainAspectRatio: false,
                    legend: {
                        display: false,
                    },
                    scales: {
                        xAxes: [
                            {
                                gridLines: {
                                    color: 'transparent',
                                    zeroLineColor: 'transparent',
                                },
                                ticks: {
                                    fontSize: 2,
                                    fontColor: 'transparent',
                                },

                            }],
                        yAxes: [
                            {
                                display: false,
                                ticks: {
                                    display: false,
                                    min: Math.min.apply(Math, m.data) - 5,
                                    max: Math.max.apply(Math, m.data) + 5,
                                },
                            }],
                    },
                    elements: {
                        line: {
                            tension: 0.00001,
                            borderWidth: 1,
                        },
                        point: {
                            radius: 4,
                            hitRadius: 10,
                            hoverRadius: 4,
                        },
                    },
                }
            }
        });
    },
    activeUserGraph: function () {
        const requestOptions = {
            headers: authHeader()
        };
        return Axios.get(`${_config.baseUrl}/api/admin/dashboard/user-active-graph?dateTime=${new Date().toISOString()}`, requestOptions).then(response => {
            let m = response.data;
            return {
                activeUserCounter: m.data.reduce((a, b) => a + b, 0),
                activeUserData: {
                    labels: m.labels,
                    datasets: [
                        {
                            label: 'Active Users',
                            backgroundColor: brandPrimary,
                            borderColor: 'rgba(255,255,255,.55)',
                            data: m.data,
                        },
                    ],
                },
                activeUserOptions: {
                    tooltips: {
                        enabled: false,
                        custom: CustomTooltips
                    },
                    maintainAspectRatio: false,
                    legend: {
                        display: false,
                    },
                    scales: {
                        xAxes: [
                            {
                                gridLines: {
                                    color: 'transparent',
                                    zeroLineColor: 'transparent',
                                },
                                ticks: {
                                    fontSize: 2,
                                    fontColor: 'transparent',
                                },

                            }],
                        yAxes: [
                            {
                                display: false,
                                ticks: {
                                    display: false,
                                    min: Math.min.apply(Math, m.data) - 5,
                                    max: Math.max.apply(Math, m.data) + 5,
                                },
                            }],
                    },
                    elements: {
                        line: {
                            tension: 0.00001,
                            borderWidth: 1,
                        },
                        point: {
                            radius: 4,
                            hitRadius: 10,
                            hoverRadius: 4,
                        },
                    },
                }
            }
        });
    },
    verifiedUserGraph: function () {
        const requestOptions = {
            headers: authHeader()
        };
        return Axios.get(`${_config.baseUrl}/api/admin/dashboard/user-verified-graph?dateTime=${new Date().toISOString()}`, requestOptions).then(response => {
            let m = response.data;

            let temp = {
                verifiedUserCounter: m.data.reduce((a, b) => a + b, 0),
                verifiedUserData: {
                    labels: m.labels,
                    datasets: [
                        {
                            label: 'Driver Registered On',
                            backgroundColor: 'rgba(255,255,255,.2)',
                            borderColor: 'rgba(255,255,255,.55)',
                            data: m.data,
                        },
                    ],
                },
                verifiedUserOptions: {
                    tooltips: {
                        enabled: false,
                        custom: CustomTooltips
                    },
                    maintainAspectRatio: false,
                    legend: {
                        display: false,
                    },
                    scales: {
                        xAxes: [
                            {
                                display: false,
                            }],
                        yAxes: [
                            {
                                display: false,
                            }],
                    },
                    elements: {
                        line: {
                            borderWidth: 2,
                        },
                        point: {
                            radius: 0,
                            hitRadius: 10,
                            hoverRadius: 4,
                        },
                    },
                }
            }
            console.log(temp);
            return temp;

        });
    },
    rideGraph: function () {
        const requestOptions = {
            headers: authHeader()
        };
        return Axios.get(`${_config.baseUrl}/api/admin/dashboard/user-online-graph?dateTime=${new Date().toISOString()}`, requestOptions).then(response => {
            let m = response.data;

            return {
                rideCounter: m.data.reduce((a, b) => a + b, 0),
                rideData: {
                    labels: m.labels,
                    datasets: [
                        {
                            label: 'Rides',
                            backgroundColor: 'rgba(255,255,255,.3)',
                            borderColor: 'transparent',
                            data: m.data,
                        },
                    ],
                },
                rideOptions: {
                    tooltips: {
                        enabled: false,
                        custom: CustomTooltips
                    },
                    maintainAspectRatio: false,
                    legend: {
                        display: false,
                    },
                    scales: {
                        xAxes: [
                            {
                                display: false,
                                barPercentage: 0.6,
                            }],
                        yAxes: [
                            {
                                display: false,
                            }],
                    },
                }
            }
        });
    },
    clientGraph: function (variant) {
        const requestOptions = {
            headers: authHeader()
        };
        return Axios.get(`${_config.baseUrl}/api/admin/dashboard/client-graph?dateTime=${new Date().toISOString()}`, requestOptions).then(response => {
            let m = response.data;

            return {
                clientCounter: m.data.reduce((a, b) => a + b, 0),
                clientData: {
                    labels: m.weeks,
                    datasets: [
                        {
                            backgroundColor: 'transparent',
                            borderColor: variant ? variant : '#c2cfd6',
                            data: m.data
                        },
                    ],

                },

            }
        });
    },
    clientAppointmentsGraph: function (variant) {
        const requestOptions = {
            headers: authHeader()
        };
        return Axios.get(`${_config.baseUrl}/api/admin/dashboard/client-appointments-graph?dateTime=${new Date().toISOString()}`, requestOptions).then(response => {
            let m = response.data;

            return {
                clientAppointmentCounter: m.data.reduce((a, b) => a + b, 0),
                clientAppointmentData: {
                    labels: m.weeks,
                    datasets: [
                        {
                            backgroundColor: 'transparent',
                            borderColor: variant ? variant : '#c2cfd6',
                            data: m.data
                        },
                    ],

                },

            }
        });
    },
    clientTasksGraph: function (variant) {
        const requestOptions = {
            headers: authHeader()
        };
        return Axios.get(`${_config.baseUrl}/api/admin/dashboard/client-tasks-graph?dateTime=${new Date().toISOString()}`, requestOptions).then(response => {
            let m = response.data;

            return {
                clientTaskCounter: m.data.reduce((a, b) => a + b, 0),
                clientTaskData: {
                    labels: m.weeks,
                    datasets: [
                        {
                            backgroundColor: 'transparent',
                            borderColor: variant ? variant : '#c2cfd6',
                            data: m.data
                        },
                    ],

                },

            }
        });
    },
    userGroupGraph: function (variant) {
        const requestOptions = {
            headers: authHeader()
        };
        return Axios.get(`${_config.baseUrl}/api/admin/dashboard/user-groups-graph?dateTime=${new Date().toISOString()}`, requestOptions).then(response => {
            let m = response.data;

            return {
                userGroupCounter: m.data.reduce((a, b) => a + b, 0),
                userGroupData: {
                    labels: m.weeks,
                    datasets: [
                        {
                            backgroundColor: 'transparent',
                            borderColor: variant ? variant : '#c2cfd6',
                            data: m.data
                        },
                    ],

                },

            }
        });
    },




};




function handleResponse(response) {
    return response.data;
}