import React, { useEffect, useState } from 'react';
import { Card, CardBody, CardHeader, Col, Row } from 'reactstrap';
import { connect } from 'react-redux';
import { toast, ToastContainer } from 'react-toastify';
import './style.css';
import { apiService } from '../../../_services/api.service';
import config from '../../../_config';
import io from 'socket.io-client';
const CountCard = ({ count, title, color }) => (
    <Col xs="12" sm="6" lg="4">
        <Card className={`text-white bg-${color}`}>
            <CardBody className="pb-4">
                <div className="text-value" >${count}</div>
                <div>{title}</div>
            </CardBody>
        </Card>
    </Col>
)

const RideTable = ({ data }) => {
    const onFeeReceived = (i) => {
        let mData = JSON.parse(JSON.stringify(data[i]));
        mData.serviceFeeReceived = true;
        mData["changesFromAdmin"] = true;
        apiService.update('rides', mData, mData._id);
    }
    const onEarningPaid = (i) => {
        let mData = JSON.parse(JSON.stringify(data[i]));
        mData.driverEarningPaid = true;
        mData["changesFromAdmin"] = true;
        apiService.update('rides', mData, mData._id);
    }
    return (
        <table className="table">
            <thead>
                <tr>
                    <th>Distance</th>
                    <th>Duration</th>
                    <th>Total Fare</th>
                    <th>Service Fee</th>
                    <th>Driver Earning</th>
                    <th>Payment Type</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                {
                    data.map((obj, i) => <tr key={i}>
                        <td>{obj.tripDistance} Miles</td>
                        <td>{obj.tripDistanceTime} Mints</td>
                        <td>${obj.fareTotal}</td>
                        <td>${obj.serviceFee}</td>
                        <td>${obj.earningDriver}</td>
                        <td>{obj.paymentType}</td>
                        {
                            !obj.serviceFeeReceived && <td>
                                <button className="btn btn-success btn-sm" onClick={() => onFeeReceived(i)}>
                                    Fee Received
                            </button>
                            </td>
                        }
                        {
                            !obj.driverEarningPaid && <td>
                                <button className="btn btn-success btn-sm" onClick={() => onEarningPaid(i)}>
                                    Earning Paid
                            </button>
                            </td>
                        }
                    </tr>)
                }
            </tbody>
        </table>
    )
}
const RideEarnings = () => {
    const [rides, setRide] = useState(null);
    const [count, setCount] = useState({
        totalFare: 0,
        serviceFee: 0,
        earningDriver: 0
    });
    useEffect(() => {
        fetchRide();

        let socket = io(config.baseUrl, config.socketHeader);
        socket.on("new-ride", fetchRide);
        socket.on("update-ride", fetchRide);
        socket.on("delete-ride", fetchRide);
    }, []);

    const fetchRide = () => {
        apiService.filter('rides', { query: { status: "Completed", } }).then(r => {
            setRide(r);

            let totalFare = 0, serviceFee = 0, earningDriver = 0
            r.forEach(mr => {
                totalFare += mr.fareTotal;
                serviceFee += (mr.serviceFeeReceived) ? mr.serviceFee : 0;
                earningDriver += (mr.driverEarningPaid) ? mr.earningDriver : 0;
            });
            setCount({
                totalFare,
                serviceFee,
                earningDriver
            })
        })
    }
    return (
        <div>
            <Row>
                <Col lg={12}>
                    <Card>
                        <CardHeader>
                            <div className="row">
                                <ToastContainer />
                                <div className="col-10">
                                    <strong><i className="fa fa-usd pr-1"></i>Ride Earnings</strong>
                                </div>
                                <div className="col-2">
                                </div>
                            </div>
                        </CardHeader>
                        <CardBody>
                            <div className="">
                                <p>
                                    Completed Ride Earning Details.
                                </p>
                            </div>
                            <div className="row">
                                <CountCard count={count.totalFare} title="Total Fares" color="primary" />
                                <CountCard count={count.serviceFee} title="Received Service Fee" color="warning" />
                                <CountCard count={count.earningDriver} title="Driver Earnings Paid" color="danger" />
                            </div>

                            {rides ? rides.length > 0 ?
                                <div className="row">
                                    <div className="col-sm-12 mb-4">
                                        <h5>Clear Rides</h5>
                                        <RideTable data={rides.filter(r => r.driverEarningPaid && r.serviceFeeReceived)} />
                                    </div>
                                    <div className="col-sm-6">
                                        <h5>Un Paid Earnings To Drivers</h5>
                                        <RideTable data={rides.filter(r => !r.driverEarningPaid)} />
                                    </div>
                                    <div className="col-sm-6">
                                        <h5>Un Paid Service Fee From Drivers</h5>
                                        <RideTable data={rides.filter(r => !r.serviceFeeReceived)} />
                                    </div>
                                </div>
                                :
                                <div>No ride data found</div>
                                :
                                <div>Loading...</div>
                            }

                        </CardBody>
                    </Card>
                </Col>
            </Row>
        </div>
    );
};

function mapStateToProps(state) {
    const { authentication } = state;
    // const {token, admin} = authentication;
    return {
        authentication
    };
}

const connected = connect(mapStateToProps)(RideEarnings);
export { connected as RideEarnings };