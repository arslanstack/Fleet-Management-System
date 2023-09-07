import React, { useEffect, useState } from 'react';
import { connect } from 'react-redux';
import { toast, ToastContainer } from 'react-toastify';
import { Card, CardBody, CardHeader, Col, Row } from 'reactstrap';
import { apiService } from '../../../_services/api.service';
const DistributeProfit = () => {
    const [isLoading, setLoading] = useState(false);
    const [plans, setPlans] = useState(false);
    useEffect(() => {
        apiService.getAll('investmentplans').then(g => {
            g.map(k => {
                k["value"] = k.maxProfitPercentage;
                k["error"] = null;
                return k;
            });
            setPlans(g)
        })
    }, [])
    const onChangeValue = (val, i) => {
        let tempPlans = JSON.parse(JSON.stringify(plans));
        if (new RegExp("\\d*\\.?\\d+").test(val)) {
            tempPlans[i].value = val;
            if (tempPlans[i].value <= 0) {
                tempPlans[i].error = "Percentage must be greater than 0";
            } else if (tempPlans[i].value > 100) {
                tempPlans[i].error = "Percentage must be less than or equal to 100";
            } else {
                tempPlans[i].error = "";
            }
        } else {
            tempPlans[i].value = val;
            tempPlans[i].error = "Invalid Percentage Value";
        }
        setPlans(tempPlans);
    }
    const validateAllErrors = () => {
        let isValid = true;
        plans.forEach(p => {
            if (p.error) {
                isValid = false
            }
        });
        return isValid;
    }
    const handleSubmit = (e) => {
        e && e.preventDefault();

        if (!validateAllErrors()) {
            toast.error("Pleas enter valid percentage of profit!");
            return;
        }

        setLoading(true);
        apiService.add(`distribute-profit`, { currentDateTime: new Date().toISOString(), plans }).then(g => {
            setLoading(false);
            toast.success(g.message);
        }).catch(e => {
            console.log(e);
            setLoading(false);
            toast.error("An Error Occured!");
        })


    }
    return (
        <div>
            <Row>
                <Col lg={8}>
                    <Card>
                        <CardHeader>
                            <div className="row">
                                <ToastContainer />
                                <div className="col-10">
                                    <strong><i className="fa fa-cube pr-1"></i>Distribute Profit</strong>
                                </div>
                                <div className="col-2">
                                </div>
                            </div>
                        </CardHeader>
                        <CardBody>
                            <div className="">
                                <p>
                                    Distribute Profit to according to activated investment plan of users.
                                </p>
                                <div className="mt-3 form col-sm-6">
                                    {
                                        plans && <form className="form" onSubmit={handleSubmit}>{plans.map((plan, i) => <div className="form-group" key={i}>
                                            <label>Enter Percentage for {plan.title}</label>
                                            <input className="form-control" placeholder="Enter Profit Percentage" value={plan.value}
                                                onChange={({ target }) => onChangeValue(target.value, i)} />
                                            <div className="alert alert-info">
                                                Suggestion for Profit Ratio: {plan.minProfitPercentage}% - {plan.maxProfitPercentage}%
                                            </div>
                                            {
                                                plan.error && <div className="alert alert-danger">
                                                    {plan.error}
                                                </div>
                                            }
                                        </div>)}
                                            <button className="btn btn-success btn-block" disabled={isLoading || !plans}>
                                                {isLoading || !plans ? "Please Wait..." : "Submit"}
                                            </button>
                                        </form>
                                    }

                                </div>


                            </div>
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

const connected = connect(mapStateToProps)(DistributeProfit);
export { connected as DistributeProfit };
