import React, { useState } from 'react'
import {Card, CardBody, CardHeader, Col, Row, Table, FormGroup, Input,Badge} from "reactstrap"
import { Link } from 'react-router-dom';
import Field from '../../../_common/field';
import PaginationComponent from "react-reactstrap-pagination";

function UserCustomNotificationRow(props) {
  console.log(props)
  const DriverObj = props.DriverObj;
  const driverDetailLink = `/drivers/detail/${DriverObj._id}`;
  const userCustomNotificationEditLink = `/user-custom-notification/edit/${DriverObj._id}`;
  const userCustomNotificationDeleteLink = `/user-custom-notifications/delete/${DriverObj._id}`;

  const getBadge = status => {
    return status === 'Active' ? 'success' :
        status === 'Inactive' ? 'secondary' :
            status === 'Pending' ? 'warning' :
                status === 'Banned' ? 'danger' :
                    'primary'

    return status ? "success" : "danger";
    
  };

  return (
    <tr>
      {/* <th scope="row"><Link to={userCustomNotificationLink}>{DriverObj.id}</Link></th> */}
      <td><Link to={driverDetailLink}>{DriverObj.name}</Link></td>
      <td>{DriverObj.email}</td>
      <td>{DriverObj.phone}  </td>
      <td>{ <Badge color={getBadge(DriverObj.status)} > {DriverObj.status}</Badge>}</td>
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

export const Drivers = () => {
  const [loading,setLoading] = useState(false)
  const [driver,setDriver] = useState([
    {_id:1, name:"Amir",email:"test@gmail.com",status:"Active"}
  ])
  const [status,setStatus] = useState("active")
  const [verified,setVarified] = useState("var")
  const [activePagination,setActivePagination] = useState({
    selectedPage:1,
    pageSize:10
  })

  

  return (
    <div className="animated fadeIn">
        <Row>
          <Col xl={12}>
            <Card>
              <CardHeader>
                <i className="fa fa-users"></i> Drivers
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
                   
                    
                  />
                </Field>
                <Table responsive hover>
                  <thead>
                    <tr>
                      {/* <th scope="col">id</th> */}
                      <th scope="col">Name</th>
                      <th scope="col">Email</th>
                      <th scope="col">Mobile no</th>
                      <th scope="col">Status</th>
                      {/* <th scope="col">Status</th> */}
                      <th scope="col">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    {driver
                      .slice(
                        (activePagination.selectedPage - 1) *
                        activePagination.pageSize,
                        activePagination.selectedPage *
                        activePagination.pageSize
                      )
                      .map((item, index) => (
                        <UserCustomNotificationRow  DriverObj={item} key={index}  />
                      ))}
                  </tbody>
                </Table>
                <PaginationComponent
                  totalItems={driver.length}
                  pageSize={activePagination.pageSize}
                 
                  maxPaginationNumbers={
                    activePagination.maxPaginationNumbers
                  }
                  activePage={activePagination.selectedPage}
                />
              </CardBody>
            </Card>
          </Col>
        </Row>
      </div>
  )
}
