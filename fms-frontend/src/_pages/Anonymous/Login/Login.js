import React, { Component } from "react";
import { connect } from "react-redux";
import {
  Button,
  Card,
  CardBody,
  CardGroup,
  Col,
  Container,
  Form,
  Input,
  InputGroup,
  Row
} from "reactstrap";
import { adminActions } from "../../../_actions/admin.actions";
import "./Login.css";
import { withRouter,useHistory } from "react-router-dom";
import { apiService } from "../../../_services/api.service";
import sygnet from './../../../assets/img/brand/sygnet.png';

const Login =()=>{
const history = useHistory()
const handleSubmit = (e)=>{
  e.preventDefault()
  history.push("/")
}


    return (
      <div className="app flex-row align-items-center login-bg">
        <Container>
          <Row className="justify-content-center">
            <Col md="5">
              <CardGroup>
                <Card className="p-4">
                  <CardBody>
                    <Form onSubmit={handleSubmit}>
                      <div className="text-center">
                        {<img src={sygnet} />}

                        <div className="mt-4">
                          <p className="text-muted">Sign In to your account</p>
                        </div>
                      </div>

                      {alert.message && (
                        <div className={`alert ${alert.type}`}>
                          {alert.message}
                        </div>
                      )}
                      <InputGroup className="mb-3">
                        {/* <InputGroupAddon addonType="prepend">
                          <InputGroupText>
                            <i className="icon-user"></i>
                          </InputGroupText>
                        </InputGroupAddon> */}
                        <Input
                          type="text"
                          className="login-input"
                          placeholder="Email"
                          autoComplete="email"
                          name="email"
                        
                        />
                      </InputGroup>
                    
                      <InputGroup className="mb-4">
                        {/* <InputGroupAddon addonType="prepend">
                          <InputGroupText>
                            <i className="icon-lock"></i>
                          </InputGroupText>
                        </InputGroupAddon> */}
                        <Input
                          type="password"
                          className="login-input"
                          placeholder="Password"
                          autoComplete="current-password"
                          name="password"
                        
                        />
                      </InputGroup>
                  
                      <Row>
                        <Col xs="12">
                          <Button
                            color="secondary"
                            className="btn-block btn-login"
                          >
                            <strong>Login</strong>
                         
                          </Button>
                        </Col>
                        {/* <Col xs="6" className="text-right">
                          <Button color="link" className="px-0">Forgot password?</Button>
                        </Col> */}
                      </Row>
                    </Form>
                  </CardBody>
                </Card>
                {/* <Card className="text-white bg-primary py-5 d-md-down-none" style={{ width: '44%' }}>
                  <CardBody className="text-center">
                    <div>
                      <h2>Sign up</h2>
                      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut
                        labore et dolore magna aliqua.</p>
                      <Link to="/register">
                        <Button color="primary" className="mt-3" active tabIndex={-1}>Register Now!</Button>
                      </Link>
                    </div>
                  </CardBody>
                </Card> */}
              </CardGroup>
            </Col>
          </Row>
        </Container>
      </div>
    );
  }


function mapStateToProps(state) {
  const { loggingIn } = state.authentication;
  const { alert } = state;
  return {
    loggingIn,
    alert
  };
}

const connectedLogin = connect(mapStateToProps)(withRouter(Login));
export { connectedLogin as Login };
