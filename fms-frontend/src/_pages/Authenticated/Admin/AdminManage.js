import React, { Component } from 'react';
import { Card, CardBody, CardHeader, Col, Row, Table, FormGroup, Input } from 'reactstrap';
import { adminActions } from '../../../_actions/admin.actions';
import { adminService } from '../../../_services/admin.service';
import { connect } from 'react-redux';
import config from '../../../_config';
import validate from 'validate.js';
import { ToastContainer, toast } from 'react-toastify';
import 'react-toastify/dist/ReactToastify.css';
import Field from '../../../_common/field';
import Notification from '../../../_common/notification';
const defaultImage = "https://png.pngtree.com/element_our/png/20181206/users-vector-icon-png_260862.jpg"; 
class AdminManage extends Component {
    state = {
        adminObj: {
            "name": "",
            "email": "",
            "phoneNo": "",
            "password": "",
            "profileImage": "",
        },
        errors: {},
        formError: null,
        loaded: 0,
        pageLoading: true
    }

    componentDidMount() {

        setTimeout(() => {
            this.setState({ adminObj: this.props.admin })
        }, 800)

    }
    getImageURL(image) {
        return image ? image.includes("http") || image.includes("base64") ? image : config.baseUrl + image : defaultImage;
    }
    static get RULES() {
        return {
            name: {
                presence: {
                    allowEmpty: false
                },

            },
            phoneNo: {
                presence: {
                    allowEmpty: true
                }
            },
            email: {
                presence: {
                    allowEmpty: false
                },
                email: {
                    message: "^Invalid Email"
                }
            },
        };
    }
    handleChange({ target }) {
        const { name, value } = target;
        const errors = validate({ [name]: value }, { [name]: AdminManage.RULES[name] });
        let obj = this.fillInObject(Object.assign({}, this.state.adminObj), name, value);
        this.setState({
            adminObj: obj,
            errors: Object.assign(
                {},
                this.state.errors,
                errors ? errors : { [name]: undefined }
            )
        });
    }
    fillInObject(obj, name, value) {
        obj[name] = value;
        return obj;
    }
    checkMimeType = (event) => {
        //getting file object
        let files = event.target.files
        //define message container
        let err = []
        // list allow mime type
        const types = ['image/png', 'image/jpeg', 'image/gif']
        // loop access array
        for (var x = 0; x < files.length; x++) {
            // compare file type find doesn't matach
            if (types.every(type => files[x].type !== type)) {
                // create error message and assign to container   
                err[x] = files[x].type + ' is not a supported format\n';
            }
        };
        for (var z = 0; z < err.length; z++) {// if message not same old that mean has error 
            // discard selected file
            toast.error(err[z])
            event.target.value = null
        }
        return (err.length > 0) ? false : true;
    }
    maxSelectFile = (event) => {
        let files = event.target.files
        if (files.length > 1) {
            const msg = 'Only 1 images can be uploaded at a time'
            event.target.value = null
            toast.warn(msg)
            return false;
        }
        return true;
    }
    checkFileSize = (event) => {
        let files = event.target.files
        let size = 2000000
        let err = [];
        for (var x = 0; x < files.length; x++) {
            if (files[x].size > size) {
                err[x] = files[x].type + 'is too large, please pick a smaller file\n';
            }
        };
        for (var z = 0; z < err.length; z++) {// if message not same old that mean has error 
            // discard selected file
            toast.error(err[z])
            event.target.value = null
        }
        return true;
    }
    onChangeHandler = event => {
        var files = event.target.files;
        if (this.maxSelectFile(event) && this.checkMimeType(event) && this.checkFileSize(event)) {
            try {


                let reader = new FileReader();
                reader.readAsDataURL(files[0]);
                reader.onload = (e) => {
                    let file = e.target.result;

                    let obj = this.fillInObject(Object.assign({}, this.state.adminObj), "profileImage", file);
                    obj.selectedImage = files[0];

                    this.setState({
                        adminObj: obj
                    });
                }
            } catch (error) {
                toast.error('Invalid Image')
            }
        }
    }
    handleSubmit(e) {
        e.preventDefault();
        const errors = validate(this.state.adminObj, AdminManage.RULES);
        debugger;
        if (errors) {
            toast.error("Form data is Invalid")
            return this.setState({ formError: null, errors });
        }

        this.setState({ isLoading: true }, () => {

            let form = new FormData();
            if (this.state.adminObj.selectedImage) {
                form.append('image', this.state.adminObj.selectedImage)
            }
            form.append('name', this.state.adminObj.name);
            form.append('email', this.state.adminObj.email);
            form.append('phoneNo', this.state.adminObj.phoneNo);
            form.append('password', this.state.adminObj.password);
            if (this.state.adminObj._id) {
                adminService.update(form, this.state.adminObj._id).then(res => {
                    this.setState({ isLoading: false }, () => {
                        toast.success("Profile Updated");
                        this.props.dispatch(adminActions.getCurrentAdmin(this.props.history));
                    })
                }).catch(err => {
                    this.setState({ isLoading: false }, () => {
                        toast.error(err.message);
                    });
                })

            }
        })
    }
    render() {
        return (
            <Row>
                <Col lg={8}>
                    <Card>
                        <CardHeader>
                            <strong><i className="fa fa-user pr-1"></i>Admin Profile Settings</strong>
                        </CardHeader>
                        {this.props.admin &&
                            <CardBody>

                                <div className="row">
                                    <div className="col-md-6">
                                        <div className="text-center">
                                            <img src={this.getImageURL(this.state.adminObj.profileImage)} style={{ height: 'auto', width: '100%' }} alt="Admin" />

                                        </div>
                                        <div className="form-group files">
                                            <label>Upload Profile Image </label>
                                            <input type="file" className="form-control" name="file" onChange={this.onChangeHandler} />
                                        </div>
                                        <div className="form-group">
                                            <ToastContainer />
                                            {/* <Progress max="100" color="success" value={this.state.loaded} >{Math.round(this.state.loaded, 2)}%</Progress> */}
                                        </div>
                                    </div>
                                    <div className="col-md-6">
                                        <form onSubmit={e => this.handleSubmit(e)} >
                                            {this.state.formError ? (
                                                <Notification type="danger" onCloseBtnClick={e => this.setState({ formError: null })}>
                                                    {this.state.formError}
                                                </Notification>
                                            ) : null}



                                            <Field label="Name" errors={this.state.errors.name}>
                                                <input
                                                    name="name"
                                                    type="text"
                                                    placeholder="Name"
                                                    value={this.state.adminObj.name}
                                                    disabled={this.state.isLoading}
                                                    onChange={e => this.handleChange(e)}
                                                />
                                            </Field>
                                            <Field label="Email" errors={this.state.errors.email}>
                                                <input
                                                    name="email"
                                                    type="email"
                                                    placeholder="Email"
                                                    value={this.state.adminObj.email}
                                                    disabled={this.state.isLoading}
                                                    onChange={e => this.handleChange(e)}
                                                />
                                            </Field>
                                            <Field label="Phone Number" errors={this.state.errors.phoneNo}>
                                                <input
                                                    name="phoneNo"
                                                    type="text"
                                                    placeholder="Email"
                                                    value={this.state.adminObj.phoneNo}
                                                    disabled={this.state.isLoading}
                                                    onChange={e => this.handleChange(e)}
                                                />
                                            </Field>
                                            <Field label="New Password" errors={this.state.errors.password}>
                                                <input
                                                    name="password"
                                                    type="password"
                                                    placeholder="New Password"
                                                    value={this.state.adminObj.password}
                                                    disabled={this.state.isLoading}
                                                    onChange={e => this.handleChange(e)}
                                                />
                                            </Field>

                                            <button className="btn btn-success btn-block" disabled={this.state.isLoading}>Save</button>
                                        </form>
                                    </div>
                                </div>
                            </CardBody>
                        }
                    </Card>
                </Col>
            </Row >
        );
    }
}
function mapStateToProps(state) {
    const { authentication } = state;
    const { token, admin } = authentication;
    return {
        token,
        admin
    };
}

const connected = connect(mapStateToProps)(AdminManage);
export { connected as AdminManage }; 