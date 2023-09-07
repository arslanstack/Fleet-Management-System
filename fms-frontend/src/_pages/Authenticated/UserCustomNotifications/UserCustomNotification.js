import React, { Component } from 'react';
import { Badge, Card, CardBody, CardHeader, Col, Row, Table } from 'reactstrap';

import { userCustomNotificationActions } from '../../../_actions/userCustomNotification.actions';
import { connect } from 'react-redux';
import config from '../../../_config';

class UserCustomNotification extends Component {
  state = {
    status: false,
    delete: false
  }

  componentDidMount() {
    const { pathname } = this.props.location;
    this.props.dispatch(userCustomNotificationActions.getSingle(this.props.match.params.id)).then(userCustomNotificationObj => {
      this.setState({ status: userCustomNotificationObj.status, delete: pathname.includes("delete") })
    })
  }
  componentDidUpdate(prevProps, prevState, snapshot) {
    if (prevProps.userCustomNotifications !== this.props.userCustomNotifications) {
      // Do whatever you want
      if (this.props.userCustomNotifications.single) {
        // this.setState({ status: this.props.userCustomNotifications.single.status, verified: this.props.userCustomNotifications.single.verified })
      }
    }
  }
  getImageURL(image) {
    return image ? image.includes("http") ? image : config.baseUrl + image : config.baseUrl + "/public/uploads/subscription-icon-png-8.png";
  }

  render() {
    const userCustomNotificationObj = this.props.userCustomNotifications && this.props.userCustomNotifications.single ? this.props.userCustomNotifications.single : null;
    const loading = this.props.userCustomNotifications.loading;
    const getBadge = (status) => {
      return status ? 'success' : 'danger'
    }

    return (
      <div>
        {
          loading ? <span><i className="text-muted icon-wait"></i> Loading...</span> :
            userCustomNotificationObj ? <div className="animated fadeIn" >
              <Row>
                <Col lg={6}>
                  <Card>
                    <CardHeader>
                      <strong><i className="icon-info pr-1"></i>User Custom Notification</strong>
                    </CardHeader>
                    <CardBody>
                      <Table responsive striped hover>
                        <tbody>

                          <tr>
                            <td>Ttile: </td><td><strong>{userCustomNotificationObj.title}</strong></td>
                          </tr>
                          <tr>
                            <td>Body: </td><td><strong>{userCustomNotificationObj.body}</strong></td>
                          </tr>

                          <tr>
                            <td>Type: </td><td><strong>{userCustomNotificationObj.type}</strong></td>
                          </tr>
                          {userCustomNotificationObj.userName != "" &&
                            <tr>
                              <td>User: </td><td><strong>{userCustomNotificationObj.userName}</strong></td>
                            </tr>
                          }

                          {this.state.delete &&
                            <tr>
                              <td>
                                Comfirmation:
                              </td>
                              <td>
                                <button className="btn btn-danger btn-sm"
                                  type="button"
                                  onClick={() => {
                                    this.props.dispatch(userCustomNotificationActions.delete(userCustomNotificationObj._id)).then(d => {
                                      this.props.history.push('/user-custom-notifications')
                                    })
                                  }}
                                >
                                  <i className="icon-trash"></i> Delete
                                </button>
                                <button className="btn btn-info btn-sm text-white ml-1"
                                  type="button"
                                  onClick={() => {
                                    this.props.history.push('/user-custom-notifications')
                                  }}
                                >
                                  Cancel
                                </button>
                              </td>
                            </tr>
                          }



                        </tbody>
                      </Table>
                    </CardBody>
                  </Card>
                </Col>


              </Row>
            </div >
              : <span><i className="text-muted icon-ban"></i> Not found</span>
        }
      </div>
    )

  }
}

function mapStateToProps(state) {
  const { userCustomNotifications } = state;
  // const {token, admin} = authentication;
  return {
    userCustomNotifications
  };
}

const connected = connect(mapStateToProps)(UserCustomNotification);
export { connected as UserCustomNotification }; 
