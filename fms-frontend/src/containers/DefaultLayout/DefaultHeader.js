import React, { Component } from 'react';
import { Link, NavLink } from 'react-router-dom';
import { Badge, UncontrolledDropdown, DropdownItem, DropdownMenu, DropdownToggle, Nav, NavItem } from 'reactstrap';
import PropTypes from 'prop-types';

import { AppAsideToggler, AppNavbarBrand, AppSidebarToggler } from '@coreui/react';
import logo from '../../assets/img/brand/logo.png'
import sygnet from '../../assets/img/brand/sygnet.png'
import { withRouter } from 'react-router-dom';

import { connect } from 'react-redux';
import { adminActions } from '../../_actions/admin.actions';
import config from '../../_config';
import './DefaultHeader.css'
import { adminNotificationService } from '../../_services/adminNotification.service';
import io from 'socket.io-client';

const propTypes = {
  children: PropTypes.node,
};

const defaultProps = {};

class DefaultHeader extends Component {
  state = {
    notifications: null
  }

  componentDidMount() {
    // this.props.dispatch(userActions.getAll());
    this.props.dispatch(adminActions.getCurrentAdmin(this.props.history))
    this.getNotificationCount();
    let socket = io(config.baseUrl, config.socketHeader);
    socket.on("new-adminnotification", (m) => {
      if (!m.isSeen) {
        this.setState({ notifications: this.state.notifications += 1 });
      }
    });
    // socket.on("update-adminNotification", (m) => {
    //   // this.getNotificationCount();
    //   if (m.isSeen) {
    //     this.setState({ notifications: this.state.notifications -= 1 });
    //   }
    // });
    // socket.on("delete-adminNotification", (m) => {
    //   this.setState({ notifications: this.state.notifications -= 1 });
    // });
  }
  getNotificationCount() {
    adminNotificationService.unSeenlist().then(notifications => {
      this.setState({ notifications: notifications.count })
    })
  }

  // getImageURL(image) {
  //   return image.includes("http") || image.includes("base64") ? image : config.baseUrl + image;
  // }
  render() {
    const { token, admin, infosetting } = this.props;
    // eslint-disable-next-line
    const { children, ...attributes } = this.props;

    return (
      <React.Fragment>
        <AppSidebarToggler className="d-lg-none" display="md" mobile />
        <AppNavbarBrand
          full={{ src: logo, width: 150, height: 42, alt: 'Seed Logo' }}
          minimized={{ src: sygnet, width: 30, height: 30, alt: 'Seed Logo' }}
        />
        <AppSidebarToggler className="d-md-down-none" display="lg" />

        <Nav className="d-md-down-none" navbar>
          <NavItem className="px-3">
            <NavLink to="/dashboard" className="nav-link" >Dashboard</NavLink>
          </NavItem>
          <NavItem className="px-3">
            <Link to="/users" className="nav-link">Users</Link>
          </NavItem>
          <NavItem className="px-3">
            <NavLink to="#" className="nav-link">Settings</NavLink>
          </NavItem>
        </Nav>
        <Nav className="ml-auto" navbar>
          {/* <NavItem className="d-md-down-none">
            <NavLink to="#" className="nav-link"><i className="icon-bell"></i><Badge pill color="danger">5</Badge></NavLink>
          </NavItem>
          <NavItem className="d-md-down-none">
            <NavLink to="#" className="nav-link"><i className="icon-list"></i></NavLink>
          </NavItem> */}
          <NavItem className="d-md-down-none">
            <NavLink to="#" className="nav-link"><i className="icon-location-pin"></i></NavLink>
          </NavItem>
          {
            admin && <UncontrolledDropdown nav direction="down">
              <DropdownToggle nav>
                <img src="https://media.istockphoto.com/id/1146517111/photo/taj-mahal-mausoleum-in-agra.jpg?s=612x612&w=0&k=20&c=vcIjhwUrNyjoKbGbAQ5sOcEzDUgOfCsm9ySmJ8gNeRk=" className="img-avatar" alt={admin.email} />
              </DropdownToggle>
              <DropdownMenu right>
                <DropdownItem header tag="div" className="text-center"><strong>{admin.email}</strong></DropdownItem>
                {/*<DropdownItem><i className="fa fa-bell-o"></i> Updates<Badge color="info">42</Badge></DropdownItem>
              <DropdownItem><i className="fa fa-envelope-o"></i> Messages<Badge color="success">42</Badge></DropdownItem>
              <DropdownItem><i className="fa fa-tasks"></i> Tasks<Badge color="danger">42</Badge></DropdownItem>
              <DropdownItem><i className="fa fa-comments"></i> Comments<Badge color="warning">42</Badge></DropdownItem> */}
                {/* <DropdownItem header tag="div" className="text-center"><strong>Settings</strong></DropdownItem> */}
                <DropdownItem onClick={e => {
                  this.props.history.push('/manage')
                }}><i className="fa fa-wrench"></i>Profile Settings</DropdownItem>
                {/* <DropdownItem><i className="fa fa-wrench"></i> Settings</DropdownItem>
              <DropdownItem><i className="fa fa-usd"></i> Payments<Badge color="secondary">42</Badge></DropdownItem>
              <DropdownItem><i className="fa fa-file"></i> Projects<Badge color="primary">42</Badge></DropdownItem> */}
                {/* <DropdownItem divider /> */}
                {/* <DropdownItem><i className="fa fa-shield"></i> Lock Account</DropdownItem> */}
                <DropdownItem onClick={e => this.props.onLogout(e)}><i className="fa fa-lock"></i> Logout</DropdownItem>
              </DropdownMenu>
            </UncontrolledDropdown>
          }

        </Nav>
        <AppAsideToggler className="d-md-down-none" >
          <div onClick={() => { adminNotificationService.allseen(); this.setState({ notifications: 0 }) }}>
            <i className="icon-bell"></i>
            {
              this.state.notifications && this.state.notifications != 0 ?
                <span className="notification-badge badge badge-danger badge-pill">{this.state.notifications}</span>
                : null
            }
          </div>




        </AppAsideToggler>
        {/*<AppAsideToggler className="d-lg-none" mobile />*/}
      </React.Fragment>
    );
  }
}

DefaultHeader.propTypes = propTypes;
DefaultHeader.defaultProps = defaultProps;


function mapStateToProps(state) {
  const { authentication } = state;
  return authentication;
}

const connected = connect(mapStateToProps)(withRouter(DefaultHeader));
export { connected as DefaultHeader };

