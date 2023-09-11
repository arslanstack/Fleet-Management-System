import React, { lazy, useState } from 'react';
import { Bar, Line } from 'react-chartjs-2';
import { Link, withRouter } from "react-router-dom";
import { Badge, Card, CardBody, CardFooter, CardHeader, CardTitle, Col, Progress, Row, } from 'reactstrap';
import { CustomTooltips } from '@coreui/coreui-plugin-chartjs-custom-tooltips';
import { getStyle, hexToRgba } from '@coreui/coreui/dist/js/coreui-utilities'
// import { dashboardService } from '../../_services/dashboard.service';

const Widget03 = lazy(() => import('../../views/Widgets/Widget03'));

const brandPrimary = getStyle('--primary')
const brandSuccess = getStyle('--success')
const brandInfo = getStyle('--info')
const brandWarning = getStyle('--warning')
const brandDanger = getStyle('--danger')

var month = new Array();
month[0] = "January";
month[1] = "February";
month[2] = "March";
month[3] = "April";
month[4] = "May";
month[5] = "June";
month[6] = "July";
month[7] = "August";
month[8] = "September";
month[9] = "October";
month[10] = "November";
month[11] = "December";

// Card Chart 1
const cardChartData1 = {
  labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
  datasets: [
    {
      label: 'Active Users',
      backgroundColor: brandPrimary,
      borderColor: 'rgba(255,255,255,.55)',
      data: [65, 59, 84, 84, 51, 55, 40],
    },
  ],
};

const cardChartOpts1 = {
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
          min: Math.min.apply(Math, cardChartData1.datasets[0].data) - 5,
          max: Math.max.apply(Math, cardChartData1.datasets[0].data) + 5,
        },
      }],
  },
  elements: {
    line: {
      borderWidth: 1,
    },
    point: {
      radius: 4,
      hitRadius: 10,
      hoverRadius: 4,
    },
  }
}


// Card Chart 2
const cardChartData2 = {
  labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
  datasets: [
    {
      label: 'Rides',
      backgroundColor: brandInfo,
      borderColor: 'rgba(255,255,255,.55)',
      data: [1, 18, 9, 17, 34, 22, 11],
    },
  ],
};

const cardChartOpts2 = {
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
          min: Math.min.apply(Math, cardChartData2.datasets[0].data) - 5,
          max: Math.max.apply(Math, cardChartData2.datasets[0].data) + 5,
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
};

// Card Chart 3
const cardChartData3 = {
  labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
  datasets: [
    {
      label: 'Rides',
      backgroundColor: 'rgba(255,255,255,.2)',
      borderColor: 'rgba(255,255,255,.55)',
      data: [78, 81, 80, 45, 34, 12, 40],
    },
  ],
};

const cardChartOpts3 = {
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
};

// Card Chart 4
const cardChartData4 = {
  labels: ['', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''],
  datasets: [
    {
      label: 'Rides',
      backgroundColor: 'rgba(255,255,255,.3)',
      borderColor: 'transparent',
      data: [78, 81, 80, 45, 34, 12, 40, 75, 34, 89, 32, 68, 54, 72, 18, 98],
    },
  ],
};

const cardChartOpts4 = {
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
};

// Social Box Chart
const socialBoxData = [
  { data: [65, 59, 84, 84, 51, 55, 40], label: 'facebook' },
  { data: [1, 13, 9, 17, 34, 41, 38], label: 'twitter' },
  { data: [78, 81, 80, 45, 34, 12, 40], label: 'linkedin' },
  { data: [35, 23, 56, 22, 97, 23, 64], label: 'google' },
];

const makeSocialBoxData = (dataSetNo) => {
  const dataset = socialBoxData[dataSetNo];
  const data = {
    labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
    datasets: [
      {
        backgroundColor: 'rgba(255,255,255,.1)',
        borderColor: 'rgba(255,255,255,.55)',
        pointHoverBackgroundColor: '#fff',
        borderWidth: 2,
        data: dataset.data,
        label: dataset.label,
      },
    ],
  };
  return () => data;
};

const socialChartOpts = {
  tooltips: {
    enabled: false,
    custom: CustomTooltips
  },
  responsive: true,
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
    point: {
      radius: 0,
      hitRadius: 10,
      hoverRadius: 4,
      hoverBorderWidth: 3,
    },
  },
};

// sparkline charts
const sparkLineChartData = [
  {
    data: [35, 23, 56, 22, 97, 23, 64],
    label: 'Clients',
  },
  {
    data: [65, 59, 84, 84, 51, 55, 40],
    label: 'Recurring Clients',
  },
  {
    data: [35, 23, 56, 22, 97, 23, 64],
    label: 'Pageviews',
  },
  {
    data: [65, 59, 84, 84, 51, 55, 40],
    label: 'Organic',
  },
  {
    data: [78, 81, 80, 45, 34, 12, 40],
    label: 'CTR',
  },
  {
    data: [1, 13, 9, 17, 34, 41, 38],
    label: 'Bounce Rate',
  },
];

const makeSparkLineData = (dataSetNo, variant) => {
  const dataset = sparkLineChartData[dataSetNo];
  const data = {
    labels: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
    datasets: [
      {
        backgroundColor: 'transparent',
        borderColor: variant ? variant : '#c2cfd6',
        data: dataset.data,
        label: dataset.label,
      },
    ],
  };
  return () => data;
};

const sparklineChartOpts = {
  tooltips: {
    enabled: false,
    custom: CustomTooltips
  },
  responsive: true,
  maintainAspectRatio: true,
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
      hoverBorderWidth: 3,
    },
  },
  legend: {
    display: false,
  },
};

// Main Chart

//Random Numbers
function random(min, max) {
  return Math.floor(Math.random() * (max - min + 1) + min);
}

var elements = 27;
var data1 = [];
var data2 = [];
var data3 = [];

for (var i = 0; i <= elements; i++) {
  data1.push(random(50, 200));
  data2.push(random(80, 100));
  data3.push(65);
}

const mainChart = {
  labels: ['Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa', 'Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa', 'Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa', 'Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa', 'Su'],
  datasets: [
    {
      label: 'My First dataset',
      backgroundColor: hexToRgba(brandInfo, 10),
      borderColor: brandInfo,
      pointHoverBackgroundColor: '#fff',
      borderWidth: 2,
      data: data1,
    },
    {
      label: 'My Second dataset',
      backgroundColor: 'transparent',
      borderColor: brandSuccess,
      pointHoverBackgroundColor: '#fff',
      borderWidth: 2,
      data: data2,
    },
    {
      label: 'My Third dataset',
      backgroundColor: 'transparent',
      borderColor: brandDanger,
      pointHoverBackgroundColor: '#fff',
      borderWidth: 1,
      borderDash: [8, 5],
      data: data3,
    },
  ],
};

const mainChartOpts = {
  tooltips: {
    enabled: false,
    custom: CustomTooltips,
    intersect: true,
    mode: 'index',
    position: 'nearest',
    callbacks: {
      labelColor: function (tooltipItem, chart) {
        return { backgroundColor: chart.data.datasets[tooltipItem.datasetIndex].borderColor }
      }
    }
  },
  maintainAspectRatio: false,
  legend: {
    display: false,
  },
  scales: {
    xAxes: [
      {
        gridLines: {
          drawOnChartArea: false,
        },
      }],
    yAxes: [
      {
        ticks: {
          beginAtZero: true,
          maxTicksLimit: 5,
          stepSize: Math.ceil(250 / 5),
          max: 250,
        },
      }],
  },
  elements: {
    point: {
      radius: 0,
      hitRadius: 10,
      hoverRadius: 4,
      hoverBorderWidth: 3,
    },
  },
};

const Dashboard = () => {
  const [dropdownOpen, setDropDownOpen] = useState(false)
  const [regiseteredUserCounter, setRegiseteredUserCounter] = useState(0)
  const [registeredUserData, setRegisteredUserData] = useState(null)
  const [activeUserCounter, setActiveUserCounter] = useState(null)
  const [radioSelected, setRadioSelected] = useState(null)
  const [activeUserOptions, setActiveUserOptions] = useState(null)
  const [registeredUserOptions, setRegisteredUserOptions] = useState(null)
  const [verifiedUserData, setVerifiedUserData] = useState(null)
  const [rideCounter, setRideCounter] = useState(null)
  const [userGroupData, setUserGroupData] = useState(null)
  const [verifiedUserCounter , setVerifiedUserCounter ] = useState(null)
  const [verifiedUserOptions , setVerifiedUserOptions ] = useState(null)
  const [clientData , setClientData ] = useState(null)
  const [activeUserData , setActiveUserData ] = useState(null)
  const [rideData , setRideData ] = useState(null)
  const [rideOptions , setRideOptions ] = useState(null)
  const [clientCounter , setClientCounter ] = useState(null)
  const [clientAppointmentCounter , setClientAppointmentCounter ] = useState(null)
  const [clientAppointmentData , setClientAppointmentData ] = useState(null)
  const [clientTaskCounter , setClientTaskCounter ] = useState(null)
  const [clientTaskData , setClientTaskData ] = useState(null)
  const [userGroupCounter , setUserGroupCounter ] = useState(null)
  


  //     state = {
  //       dropdownOpen: false,
  //       radioSelected: 2,
  //       mainChart: null,
  //       regiseteredUserCounter: null,
  //       registeredUserData: null,
  //       registeredUserOptions: null,
  //       activeUserCounter: null,
  //       activeUserData: null,
  //       activeUserOptions: null,
  //       verifiedUserCounter: null,
  //       verifiedUserData: null,
  //       verifiedUserOptions: null,
  //       rideCounter: null,
  //       rideData: null,
  //       rideOptions: null,
  //       clientCounter: null,
  //       clientData: null,
  //       clientAppointmentCounter: null,
  //       clientAppointmentData: null,
  //       clientTaskCounter: null,
  //       clientTaskData: null,
  //       userGroupCounter: null,
  //       userGroupData: null,
  //     };
  //   }

  //     // dashboardService.userCounter().then(counter => {
  //     //   this.setState({ userCounter: counter })
  //     // })
  //     let x = 0;

  //     dashboardService.registeredUserGraph().then(m => {
  //       x++;
  //       this.setState(m);
  //     });
  //     dashboardService.activeUserGraph().then(m => {
  //       x++;
  //       this.setState(m);
  //     });
  //     dashboardService.verifiedUserGraph().then(m => {
  //       x++;
  //       this.setState(m);
  //     });
  //     dashboardService.rideGraph().then(m => {
  //       x++;
  //       this.setState(m);
  //     });
  //     dashboardService.clientGraph(brandPrimary).then(m => {
  //       x++;
  //       this.setState(m);
  //     });
  //     dashboardService.clientAppointmentsGraph(brandDanger).then(m => {
  //       x++;
  //       this.setState(m);
  //     });
  //     dashboardService.clientTasksGraph(brandWarning).then(m => {
  //       x++;
  //       this.setState(m);
  //     });
  //     dashboardService.userGroupGraph(brandSuccess).then(m => {
  //       x++;
  //       this.setState(m);
  //     });
  //     let i = setInterval(() => {
  //       if (x > 4) {
  //         clearInterval(i); console.log();

  //         this.setState({
  //           mainChart: {
  //             labels: registeredUserData.labels,
  //             datasets: [
  //               {
  //                 label: 'Registered Users',
  //                 backgroundColor: hexToRgba(brandInfo, 10),
  //                 borderColor: brandInfo,
  //                 pointHoverBackgroundColor: '#fff',
  //                 borderWidth: 2,
  //                 data: registeredUserData.datasets[0].data,
  //               },
  //               {
  //                 label: 'Active Users',
  //                 backgroundColor: 'transparent',
  //                 borderColor: brandSuccess,
  //                 pointHoverBackgroundColor: '#fff',
  //                 borderWidth: 2,
  //                 // data: data2,
  //                 data: activeUserData.datasets[0].data,
  //               },
  //               {
  //                 label: 'Online Users',
  //                 backgroundColor: 'transparent',
  //                 borderColor: brandDanger,
  //                 pointHoverBackgroundColor: '#fff',
  //                 borderWidth: 1,
  //                 borderDash: [8, 5],
  //                 // data: data3,
  //                 data: rideData.datasets[0].data,
  //               },
  //             ],
  //           }
  //         })
  //       }
  //     }, 500);


  //  const toggle=() =>{
  //     this.setState({
  //       dropdownOpen: !dropdownOpen,
  //     });
  //   }

  //   onRadioBtnClick(radioSelected) {
  //     this.setState({
  //       radioSelected: radioSelected,
  //     });
  //   }

  //   const loading = () => <div className="animated fadeIn pt-1 text-center">Loading...</div>



  return (
    <div className="animated fadeIn">
      <Row>

        <Col xs="12" sm="6" lg="3" >
          <Link to='/users?filter={"role":"Rider"}' style={{ textDecoration: 'none' }}>
            <Card className="text-white bg-info">
              <CardBody className="pb-0">
                <div className="text-value">{regiseteredUserCounter ? regiseteredUserCounter : "Loading..."}</div>
                <div>Riders</div>
              </CardBody>
              <div className="chart-wrapper mx-3" style={{ height: '70px' }}>
                <Line
                  data={registeredUserData ? registeredUserData : cardChartData2}
                  options={registeredUserOptions ? registeredUserOptions : cardChartOpts2}
                  height={70} />
              </div>
            </Card>
          </Link>
        </Col>

        <Col xs="12" sm="6" lg="3">
          <Link to='users?filter={"role":"Driver"}' style={{ textDecoration: 'none' }}>
            <Card className="text-white bg-warning">
              <CardBody className="pb-0">
                <div className="text-value" > {verifiedUserCounter ? verifiedUserCounter : "Loading..."}</div>
                <div>Drivers</div>

              </CardBody>
              <div className="chart-wrapper" style={{ height: '70px' }}>
                <Line
                  data={verifiedUserData ? verifiedUserData : cardChartData3}
                  options={verifiedUserOptions ? verifiedUserOptions : cardChartOpts3}
                  height={70} />
              </div>
            </Card>
          </Link>
        </Col>


        <Col xs="12" sm="6" lg="3">
          <Link to="/user/filter/active" style={{ textDecoration: 'none' }}>
            <Card className="text-white bg-primary">
              <CardBody className="pb-0">
                <div className="text-value">{activeUserCounter ? activeUserCounter : "Loading..."}</div>
                <div>Active Users</div>
              </CardBody>
              <div className="chart-wrapper mx-3" style={{ height: '70px' }}>
                <Line
                  data={activeUserData ? activeUserData : cardChartData1}
                  options={activeUserOptions ? activeUserOptions : cardChartOpts1}
                  height={70} />
              </div>
            </Card>
          </Link>
        </Col>


        <Col xs="12" sm="6" lg="3">
          <Link to="/rides" style={{ textDecoration: 'none' }}>
            <Card className="text-white bg-danger">
              <CardBody className="pb-0">
                <div className="text-value" > {rideCounter ? rideCounter : "Loading..."}</div>
                <div>Rides</div>
              </CardBody>
              <div className="chart-wrapper mx-3" style={{ height: '70px' }}>
                <Bar
                  data={rideData ? rideData : cardChartData4}
                  options={rideOptions ? rideOptions : cardChartOpts4}
                  height={70} />
              </div>
            </Card>
          </Link>
        </Col>
      </Row>
      <Row>
        <Col>
          <Card>
            <CardBody>
              <Row>
                <Col sm="5">
                  <CardTitle className="mb-0">Traffic</CardTitle>
                  <div className="small text-muted">{month[new Date().getMonth()]} {new Date().getFullYear()}</div>
                </Col>
                {/* <Col sm="7" className="d-none d-sm-inline-block">
                  <Button color="primary" className="float-right"><i className="icon-cloud-download"></i></Button>
                    <ButtonToolbar className="float-right" aria-label="Toolbar with button groups">
                      <ButtonGroup className="mr-3" aria-label="First group">
                        <Button color="outline-secondary" onClick={() => this.onRadioBtnClick(1)} active={radioSelected === 1}>Day</Button>
                        <Button color="outline-secondary" onClick={() => this.onRadioBtnClick(2)} active={radioSelected === 2}>Month</Button>
                        <Button color="outline-secondary" onClick={() => this.onRadioBtnClick(3)} active={radioSelected === 3}>Year</Button>
                      </ButtonGroup>
                    </ButtonToolbar>
                </Col> */}
              </Row>
              <div className="chart-wrapper" style={{ height: 300 + 'px', marginTop: 40 + 'px' }}>
                <Line data={mainChart ? mainChart : mainChart} options={mainChartOpts} height={300} />
              </div>
            </CardBody>
            <CardFooter>
              <Row className="text-center">
                <Col sm={12} md className="mb-sm-2 mb-0">
                  <div className="text-muted">Visits</div>
                  <strong>29.703 Users (40%)</strong>
                  <Progress className="progress-xs mt-2" color="success" value="40" />
                </Col>
                <Col sm={12} md className="mb-sm-2 mb-0 d-md-down-none">
                  <div className="text-muted">Unique</div>
                  <strong>24.093 Users (20%)</strong>
                  <Progress className="progress-xs mt-2" color="info" value="20" />
                </Col>
                <Col sm={12} md className="mb-sm-2 mb-0">
                  <div className="text-muted">Pageviews</div>
                  <strong>78.706 Views (60%)</strong>
                  <Progress className="progress-xs mt-2" color="warning" value="60" />
                </Col>
                <Col sm={12} md className="mb-sm-2 mb-0">
                  <div className="text-muted">New Users</div>
                  <strong>22.123 Users (80%)</strong>
                  <Progress className="progress-xs mt-2" color="danger" value="80" />
                </Col>
                <Col sm={12} md className="mb-sm-2 mb-0 d-md-down-none">
                  <div className="text-muted">Bounce Rate</div>
                  <strong>Average Rate (40.15%)</strong>
                  <Progress className="progress-xs mt-2" color="primary" value="40" />
                </Col>
              </Row>
            </CardFooter>
          </Card>
        </Col>
      </Row>

      {/* <Row>
          <Col xs="6" sm="6" lg="3">
            <Suspense fallback={this.loading()}>
              <Widget03 dataBox={() => ({ variant: 'facebook', friends: '89k', feeds: '459' })} >
                <div className="chart-wrapper">
                  <Line data={makeSocialBoxData(0)} options={socialChartOpts} height={90} />
                </div>
              </Widget03>
            </Suspense>
          </Col>

          <Col xs="6" sm="6" lg="3">
            <Suspense fallback={this.loading()}>
              <Widget03 dataBox={() => ({ variant: 'twitter', followers: '973k', tweets: '1.792' })} >
                <div className="chart-wrapper">
                  <Line data={makeSocialBoxData(1)} options={socialChartOpts} height={90} />
                </div>
              </Widget03>
            </Suspense>
          </Col>

          <Col xs="6" sm="6" lg="3">
            <Suspense fallback={this.loading()}>
              <Widget03 dataBox={() => ({ variant: 'linkedin', contacts: '500+', feeds: '292' })} >
                <div className="chart-wrapper">
                  <Line data={makeSocialBoxData(2)} options={socialChartOpts} height={90} />
                </div>
              </Widget03>
            </Suspense>
          </Col>

          <Col xs="6" sm="6" lg="3">
            <Suspense fallback={this.loading()}>
              <Widget03 dataBox={() => ({ variant: 'google-plus', followers: '894', circles: '92' })} >
                <div className="chart-wrapper">
                  <Line data={makeSocialBoxData(3)} options={socialChartOpts} height={90} />
                </div>
              </Widget03>
            </Suspense>
          </Col>
        </Row> */}

      <Row>
        <Col>
          <Card>
            <CardHeader>
              Traffic {' & '} Activity
            </CardHeader>
            <CardBody>
              <Row>
                <Col xs="12" md="6" xl="6">
                  <Row>
                    <Col sm="6">
                      <div className="callout callout-info">
                        <small className="text-muted">Clients</small>
                        <br />
                        <strong className="h4">{clientCounter ? clientCounter : 0}</strong>

                        <div className="chart-wrapper">
                          <Line data={clientData ? clientData : makeSparkLineData(0, brandPrimary)} options={sparklineChartOpts} width={100} height={30} />
                        </div>
                      </div>
                    </Col>
                    <Col sm="6">
                      <div className="callout callout-danger">
                        <small className="text-muted">Agends</small>
                        <br />
                        <strong className="h4">{clientAppointmentCounter ? clientAppointmentCounter : 0}</strong>

                        <div className="chart-wrapper">
                          <Line data={clientAppointmentData ? clientAppointmentData : makeSparkLineData(1, brandDanger)} options={sparklineChartOpts} width={100} height={30} />
                        </div>
                      </div>
                    </Col>
                  </Row>
                  <hr className="mt-0" />
                  {clientData && clientAppointmentData &&
                    clientData.labels.map((label, key) => {
                      const counter1 = clientData.datasets[0].data[key];
                      const counter2 = clientAppointmentData.datasets[0].data[key];
                      return (<div className="progress-group mb-4" key={key}>
                        <div className="progress-group-prepend">
                          <span className="progress-group-text">
                            {label}
                          </span>
                        </div>
                        <div className="progress-group-bars">
                          <Progress className="progress-xs" color="info" value={(counter1 * 3) > 100 ? 100 : counter1 * 3} />
                          <Progress className="progress-xs" color="danger" value={(counter2 * 3) > 100 ? 100 : counter2 * 3} />
                        </div>
                      </div>)
                    })
                  }


                  <div className="legend text-center">
                    <small>
                      <sup className="px-1"><Badge pill color="info">&nbsp;</Badge></sup>
                      Clients
                      &nbsp;
                      <sup className="px-1"><Badge pill color="danger">&nbsp;</Badge></sup>
                      Agendas
                    </small>
                  </div>
                </Col>
                <Col xs="12" md="6" xl="6">
                  <Row>
                    <Col sm="6">
                      <div className="callout callout-warning">
                        <small className="text-muted">Tasks</small>
                        <br />
                        <strong className="h4">{clientTaskCounter ? clientTaskCounter : 0}</strong>
                        <div className="chart-wrapper">
                          <Line data={clientTaskData ? clientTaskData : makeSparkLineData(2, brandWarning)} options={sparklineChartOpts} width={100} height={30} />
                        </div>
                      </div>
                    </Col>
                    <Col sm="6">
                      <div className="callout callout-success">
                        <small className="text-muted">Groups</small>
                        <br />
                        <strong className="h4">{userGroupCounter ? userGroupCounter : 0}</strong>
                        <div className="chart-wrapper">
                          <Line data={userGroupData ? userGroupData : makeSparkLineData(3, brandSuccess)} options={sparklineChartOpts} width={100} height={30} />
                        </div>
                      </div>
                    </Col>
                  </Row>
                  <hr className="mt-0" />
                  {clientTaskData && userGroupData &&
                    clientTaskData.labels.map((label, key) => {
                      const counter1 = clientTaskData.datasets[0].data[key];
                      const counter2 = userGroupData.datasets[0].data[key];
                      return (<div className="progress-group mb-4" key={key}>
                        <div className="progress-group-prepend">
                          <span className="progress-group-text">
                            {label}
                          </span>
                        </div>
                        <div className="progress-group-bars">
                          <Progress className="progress-xs" color="warning" value={(counter1 * 3) > 100 ? 100 : counter1 * 3} />
                          <Progress className="progress-xs" color="success" value={(counter2 * 3) > 100 ? 100 : counter2 * 3} />
                        </div>
                      </div>)
                    })
                  }
                  <div className="legend text-center">
                    <small>
                      <sup className="px-1"><Badge pill color="warning">&nbsp;</Badge></sup>
                      Tasks
                      &nbsp;
                      <sup className="px-1"><Badge pill color="success">&nbsp;</Badge></sup>
                      Groups
                    </small>
                  </div>
                </Col>
              </Row>
              <br />
              {/* <Table hover responsive className="table-outline mb-0 d-none d-sm-table">
                  <thead className="thead-light">
                    <tr>
                      <th className="text-center"><i className="icon-people"></i></th>
                      <th>User</th>
                      <th className="text-center">Country</th>
                      <th>Usage</th>
                      <th className="text-center">Payment Method</th>
                      <th>Activity</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td className="text-center">
                        <div className="avatar">
                          <img src={'assets/img/avatars/1.jpg'} className="img-avatar" alt="admin@bootstrapmaster.com" />
                          <span className="avatar-status badge-success"></span>
                        </div>
                      </td>
                      <td>
                        <div>Yiorgos Avraamu</div>
                        <div className="small text-muted">
                          <span>New</span> | Registered: Jan 1, 2015
                      </div>
                      </td>
                      <td className="text-center">
                        <i className="flag-icon flag-icon-us h4 mb-0" title="us" id="us"></i>
                      </td>
                      <td>
                        <div className="clearfix">
                          <div className="float-left">
                            <strong>50%</strong>
                          </div>
                          <div className="float-right">
                            <small className="text-muted">Jun 11, 2015 - Jul 10, 2015</small>
                          </div>
                        </div>
                        <Progress className="progress-xs" color="success" value="50" />
                      </td>
                      <td className="text-center">
                        <i className="fa fa-cc-mastercard" style={{ fontSize: 24 + 'px' }}></i>
                      </td>
                      <td>
                        <div className="small text-muted">Last login</div>
                        <strong>10 sec ago</strong>
                      </td>
                    </tr>
                    <tr>
                      <td className="text-center">
                        <div className="avatar">
                          <img src={'assets/img/avatars/2.jpg'} className="img-avatar" alt="admin@bootstrapmaster.com" />
                          <span className="avatar-status badge-danger"></span>
                        </div>
                      </td>
                      <td>
                        <div>Avram Tarasios</div>
                        <div className="small text-muted">

                          <span>Recurring</span> | Registered: Jan 1, 2015
                      </div>
                      </td>
                      <td className="text-center">
                        <i className="flag-icon flag-icon-br h4 mb-0" title="br" id="br"></i>
                      </td>
                      <td>
                        <div className="clearfix">
                          <div className="float-left">
                            <strong>10%</strong>
                          </div>
                          <div className="float-right">
                            <small className="text-muted">Jun 11, 2015 - Jul 10, 2015</small>
                          </div>
                        </div>
                        <Progress className="progress-xs" color="info" value="10" />
                      </td>
                      <td className="text-center">
                        <i className="fa fa-cc-visa" style={{ fontSize: 24 + 'px' }}></i>
                      </td>
                      <td>
                        <div className="small text-muted">Last login</div>
                        <strong>5 minutes ago</strong>
                      </td>
                    </tr>
                    <tr>
                      <td className="text-center">
                        <div className="avatar">
                          <img src={'assets/img/avatars/3.jpg'} className="img-avatar" alt="admin@bootstrapmaster.com" />
                          <span className="avatar-status badge-warning"></span>
                        </div>
                      </td>
                      <td>
                        <div>Quintin Ed</div>
                        <div className="small text-muted">
                          <span>New</span> | Registered: Jan 1, 2015
                      </div>
                      </td>
                      <td className="text-center">
                        <i className="flag-icon flag-icon-in h4 mb-0" title="in" id="in"></i>
                      </td>
                      <td>
                        <div className="clearfix">
                          <div className="float-left">
                            <strong>74%</strong>
                          </div>
                          <div className="float-right">
                            <small className="text-muted">Jun 11, 2015 - Jul 10, 2015</small>
                          </div>
                        </div>
                        <Progress className="progress-xs" color="warning" value="74" />
                      </td>
                      <td className="text-center">
                        <i className="fa fa-cc-stripe" style={{ fontSize: 24 + 'px' }}></i>
                      </td>
                      <td>
                        <div className="small text-muted">Last login</div>
                        <strong>1 hour ago</strong>
                      </td>
                    </tr>
                    <tr>
                      <td className="text-center">
                        <div className="avatar">
                          <img src={'assets/img/avatars/4.jpg'} className="img-avatar" alt="admin@bootstrapmaster.com" />
                          <span className="avatar-status badge-secondary"></span>
                        </div>
                      </td>
                      <td>
                        <div>Enéas Kwadwo</div>
                        <div className="small text-muted">
                          <span>New</span> | Registered: Jan 1, 2015
                      </div>
                      </td>
                      <td className="text-center">
                        <i className="flag-icon flag-icon-fr h4 mb-0" title="fr" id="fr"></i>
                      </td>
                      <td>
                        <div className="clearfix">
                          <div className="float-left">
                            <strong>98%</strong>
                          </div>
                          <div className="float-right">
                            <small className="text-muted">Jun 11, 2015 - Jul 10, 2015</small>
                          </div>
                        </div>
                        <Progress className="progress-xs" color="danger" value="98" />
                      </td>
                      <td className="text-center">
                        <i className="fa fa-paypal" style={{ fontSize: 24 + 'px' }}></i>
                      </td>
                      <td>
                        <div className="small text-muted">Last login</div>
                        <strong>Last month</strong>
                      </td>
                    </tr>
                    <tr>
                      <td className="text-center">
                        <div className="avatar">
                          <img src={'assets/img/avatars/5.jpg'} className="img-avatar" alt="admin@bootstrapmaster.com" />
                          <span className="avatar-status badge-success"></span>
                        </div>
                      </td>
                      <td>
                        <div>Agapetus Tadeáš</div>
                        <div className="small text-muted">
                          <span>New</span> | Registered: Jan 1, 2015
                      </div>
                      </td>
                      <td className="text-center">
                        <i className="flag-icon flag-icon-es h4 mb-0" title="es" id="es"></i>
                      </td>
                      <td>
                        <div className="clearfix">
                          <div className="float-left">
                            <strong>22%</strong>
                          </div>
                          <div className="float-right">
                            <small className="text-muted">Jun 11, 2015 - Jul 10, 2015</small>
                          </div>
                        </div>
                        <Progress className="progress-xs" color="info" value="22" />
                      </td>
                      <td className="text-center">
                        <i className="fa fa-google-wallet" style={{ fontSize: 24 + 'px' }}></i>
                      </td>
                      <td>
                        <div className="small text-muted">Last login</div>
                        <strong>Last week</strong>
                      </td>
                    </tr>
                    <tr>
                      <td className="text-center">
                        <div className="avatar">
                          <img src={'assets/img/avatars/6.jpg'} className="img-avatar" alt="admin@bootstrapmaster.com" />
                          <span className="avatar-status badge-danger"></span>
                        </div>
                      </td>
                      <td>
                        <div>Friderik Dávid</div>
                        <div className="small text-muted">
                          <span>New</span> | Registered: Jan 1, 2015
                      </div>
                      </td>
                      <td className="text-center">
                        <i className="flag-icon flag-icon-pl h4 mb-0" title="pl" id="pl"></i>
                      </td>
                      <td>
                        <div className="clearfix">
                          <div className="float-left">
                            <strong>43%</strong>
                          </div>
                          <div className="float-right">
                            <small className="text-muted">Jun 11, 2015 - Jul 10, 2015</small>
                          </div>
                        </div>
                        <Progress className="progress-xs" color="success" value="43" />
                      </td>
                      <td className="text-center">
                        <i className="fa fa-cc-amex" style={{ fontSize: 24 + 'px' }}></i>
                      </td>
                      <td>
                        <div className="small text-muted">Last login</div>
                        <strong>Yesterday</strong>
                      </td>
                    </tr>
                  </tbody>
                </Table>*/}
            </CardBody>
          </Card>
        </Col>
      </Row>
    </div >
  );
}


export default withRouter(Dashboard);
