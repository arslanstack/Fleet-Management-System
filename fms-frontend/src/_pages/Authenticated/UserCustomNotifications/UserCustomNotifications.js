import React, { Component } from "react";
import { Link } from "react-router-dom";
import { Card, CardBody, CardHeader, Col, Row, Table, Badge } from "reactstrap";
import { userCustomNotificationActions } from "../../../_actions/userCustomNotification.actions";
import { connect } from "react-redux";
import PaginationComponent from "react-reactstrap-pagination";
import Field from '../../../_common/field';
function UserCustomNotificationRow(props) {
  const userCustomNotificationObj = props.userCustomNotification;
  const userCustomNotificationLink = `/user-custom-notifications/detail/${userCustomNotificationObj._id}`;
  const userCustomNotificationEditLink = `/user-custom-notification/edit/${userCustomNotificationObj._id}`;
  const userCustomNotificationDeleteLink = `/user-custom-notifications/delete/${userCustomNotificationObj._id}`;

  const getBadge = status => {
    // return status === 'Active' ? 'success' :
    //     status === 'Inactive' ? 'secondary' :
    //         status === 'Pending' ? 'warning' :
    //             status === 'Banned' ? 'danger' :
    //                 'primary'

    return status ? "success" : "danger";
  };

  return (
    <tr>
      {/* <th scope="row"><Link to={userCustomNotificationLink}>{userCustomNotificationObj.id}</Link></th> */}
      <td><Link to={userCustomNotificationLink}>{userCustomNotificationObj.title}</Link></td>
      <td>{userCustomNotificationObj.body}</td>
      <td>{userCustomNotificationObj.type} {userCustomNotificationObj.userName != "" && `(${userCustomNotificationObj.userName})`} </td>
      <td>{userCustomNotificationObj.senderType}</td>
      <td>
        {/* <Link to={userCustomNotificationEditLink}>
          <i className="fa fa-edit"></i>
        </Link> */}
        <Link to={userCustomNotificationDeleteLink} className="ml-2 text-danger">
          {/* <i className="fa fa-trash"></i> */}
          <i className="icon-trash"></i>
        </Link>
      </td>
    </tr>
  );
}

class UserCustomNotifications extends Component {
  state = {
    activePagination: {
      pageLoading: true,
      selectedPage: 1,
      pageSize: 10,
      maxPaginationNumbers: 9
    },
    searching: false,
    userCustomNotificationList: [],
    filteredUserCustomNotificationList: []
  };
  componentDidMount() {
    this.props.dispatch(userCustomNotificationActions.getAll()).then(p => {
      let userCustomNotificationList = this.props.userCustomNotifications && this.props.userCustomNotifications.list ? this.props.userCustomNotifications.list : [];
      console.log(userCustomNotificationList)
      this.setState({ userCustomNotificationList, filteredUserCustomNotificationList: userCustomNotificationList })
    });
  }
  doSearch = ({ target }) => {
    if (!this.state.searching) {

      this.setState({ searching: true })
      const { name, value } = target;
      let filteredUserCustomNotificationList = this.state.userCustomNotificationList;
      // let filteredUserCustomNotificationList = JSON.parse(JSON.stringify(this.state.userCustomNotificationList));
      let searchText = value.toLowerCase();
      if (filteredUserCustomNotificationList && filteredUserCustomNotificationList.length > 0) {
        filteredUserCustomNotificationList = filteredUserCustomNotificationList.filter(u =>
          (u.title && u.title.toLowerCase().includes(searchText)) ||
          (u.type && u.type.toString().toLowerCase().includes(searchText)) ||
          (u.userName && u.userName.toString().toLowerCase().includes(searchText)) ||
          (u.body && u.body.toLowerCase().includes(searchText))
        )

      }
      this.setState({ filteredUserCustomNotificationList, searching: false })
    }
  }
  handleSelectedActivePage = selectedPage => {
    let activePagination = this.state.activePagination;
    activePagination.selectedPage = selectedPage;
    this.setState({ activePagination });
  };
  render() {
    // const userCustomNotificationList = userCustomNotificationsData
    const { userCustomNotificationList, filteredUserCustomNotificationList } = this.state;

    return (
      <div className="animated fadeIn">
        <Row>
          <Col xl={12}>
            <Card>
              <CardHeader>
                <i className="fa fa-cube"></i> User Custom Notifications
                <Link
                  to={`/user-custom-notification/add`}
                  className="btn btn-primary btn-sm"
                  style={{ float: "right" }}
                >
                  Add New
                </Link>
              </CardHeader>
              <CardBody>
                <Field>
                  <input
                    name="search"
                    type="text"
                    placeholder="Search..."
                    disabled={this.state.searching}
                    onChange={e => this.doSearch(e)}
                  />
                </Field>
                <Table responsive hover>
                  <thead>
                    <tr>
                      {/* <th scope="col">id</th> */}
                      <th scope="col">Title</th>
                      <th scope="col">Body</th>
                      <th scope="col">Type</th>
                      <th scope="col">Sender Type</th>
                      {/* <th scope="col">Status</th> */}
                      <th scope="col">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    {filteredUserCustomNotificationList
                      .slice(
                        (this.state.activePagination.selectedPage - 1) *
                        this.state.activePagination.pageSize,
                        this.state.activePagination.selectedPage *
                        this.state.activePagination.pageSize
                      )
                      .map((userCustomNotificationObj, index) => (
                        <UserCustomNotificationRow key={index} userCustomNotification={userCustomNotificationObj} key={userCustomNotificationObj._id.toString()} />
                      ))}
                  </tbody>
                </Table>
                <PaginationComponent
                  totalItems={filteredUserCustomNotificationList.length}
                  pageSize={this.state.activePagination.pageSize}
                  onSelect={this.handleSelectedActivePage}
                  maxPaginationNumbers={
                    this.state.activePagination.maxPaginationNumbers
                  }
                  activePage={this.state.activePagination.selectedPage}
                />
              </CardBody>
            </Card>
          </Col>
        </Row>
      </div>
    );
  }
}

function mapStateToProps(state) {
  const { userCustomNotifications } = state;
  // const { token, admin } = authentication;
  return {
    userCustomNotifications
  };
}

const connected = connect(mapStateToProps)(UserCustomNotifications);
export { connected as UserCustomNotifications };
