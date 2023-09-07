import React, { Component } from 'react';
import { Card, CardBody, CardHeader, Col, Row } from 'reactstrap';

import { userCustomNotificationActions } from '../../../_actions/userCustomNotification.actions';
import { settingsService } from '../../../_services/settings.service';
import { userService } from '../../../_services/user.service';
import { connect } from 'react-redux';
import config from '../../../_config';
import validate from 'validate.js';
import { ToastContainer, toast } from 'react-toastify';
import 'react-toastify/dist/ReactToastify.css';
import Field from '../../../_common/field';
import Notification from '../../../_common/notification';
const defaultImage = "https://c7.uihere.com/icons/22/702/390/staff-channel-app-default-0c2f68d42cf81f4f6cedf5fc0c6894d8.png";
class UserCustomNotificationManage extends Component {
  state = {
    userCustomNotificationObj: {
      "_id": "",
      "title": "",
      "body": "",
      "type": "",
      "userId": "",
      "senderType": "",
      "image": defaultImage,
      "selectedImage": null,
      "status": true,
    },
    setting: null,
    errors: {},
    formError: null,
    loaded: 0,
    pageLoading: true,
    users: []
  }

  componentDidMount() {
    settingsService.Get().then(setting => {
      userService.getAll().then(users => {
        this.setState({
          setting, users: users.filter(m => m.status
            // && m.isEmailConfirmed
            // && m.verified 
            && m.expoToken && m.expoToken != "UnSet"
          )
        });
      })
    })
    if (this.props.match.params.id) {
      this.props.dispatch(userCustomNotificationActions.getSingle(this.props.match.params.id)).then(userCustomNotificationObj => {
        this.setState({ userCustomNotificationObj })
      }).catch(m => {
        this.props.history.push('/user-custom-notifications')
      })
    }


  }

  getImageURL(image) {
    return image ? image.includes("http") || image.includes("base64") ? image
      : config.baseUrl + image : defaultImage;
  }

  convertAllParametersToString(ad) {
    for (var prop in ad) {
      ad[prop] += "";
    }
    return ad;
  }
  static get RULES() {
    return {
      title: { presence: { allowEmpty: false }, },
      body: { presence: { allowEmpty: true } },
      type: { presence: { allowEmpty: true } },
      userId: { presence: { allowEmpty: false } },
      senderType: { presence: { allowEmpty: false } },
    };
  }
  handleChange({ target }) {
    const { name, value } = target;
    const errors = validate({ [name]: value }, { [name]: UserCustomNotificationManage.RULES[name] });
    let obj = this.fillInObject(Object.assign({}, this.state.userCustomNotificationObj), name, value);
    this.setState({
      userCustomNotificationObj: obj,
      errors: Object.assign(
        {},
        this.state.errors,
        errors ? errors : { [name]: undefined }
      )
    });
  }
  handleModulesChange(name, value, i) {
    // const errors = validate({ "modules": value }, { "modules": UserCustomNotificationManage.RULES.modules });
    let obj = this.state.userCustomNotificationObj;
    obj.modules = this.fillInSubObject(obj.modules, name, i, value);
    this.setState({
      userCustomNotificationObj: obj,
      // errors: Object.assign(
      //   {},
      //   this.state.errors,
      //   errors ? errors : { modules: undefined }
      // )
    });
  }
  fillInObject(obj, name, value) {
    obj[name] = value;
    return obj;
  }
  fillInSubObject(obj, name, i, value) {
    obj[i][name] = value;
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
          // base 64
          let file = e.target.result;

          let obj = this.fillInObject(Object.assign({}, this.state.userCustomNotificationObj), "image", file);
          obj.selectedImage = files[0];

          this.setState({
            userCustomNotificationObj: obj
          });
        }
      } catch (error) {
        toast.error('Invalid Image')
      }
    }
  }
  isContainProps(ad) {
    let rt = false;
    for (var prop in ad) {
      if (ad[prop] && ad.hasOwnProperty(prop)) {
        rt = true;
        // handle prop as required
      }
    }
    return rt;
  }
  handleSubmit(e) {
    e.preventDefault();
    let rules = UserCustomNotificationManage.RULES;
    if (this.state.userCustomNotificationObj.type === "All Users") {
      delete rules["userId"];
    }

    // if (this.state.userCustomNotificationObj.image) {
    const errors = validate(this.state.userCustomNotificationObj, rules);
    debugger;
    if (errors) {
      toast.error("Form data is Invalid")
      return this.setState({ formError: null, errors });
    }

    this.setState({ isLoading: true }, () => {
      let data = JSON.parse(JSON.stringify(this.state.userCustomNotificationObj));
      data["users"] = this.state.users;
      if (!this.state.userCustomNotificationObj._id) {
        this.props.dispatch(userCustomNotificationActions.add(data)).then(res => {
          toast.success(res.message);
          setTimeout(() => {
            this.props.history.push('/user-custom-notifications')
          }, 3000);

        }).catch(err => {
          this.setState({ isLoading: false });
          toast.error(err.response.data.message);
        })
      } else {
        this.props.dispatch(userCustomNotificationActions.update(data, this.state.userCustomNotificationObj._id)).then(res => {
          this.props.history.push('/user-custom-notifications')
        }).catch(err => {
          this.setState({ isLoading: false });
          toast.error(err.response.data.message);
        })
      }
    })



    // } else {
    //   toast.error("Please Upload Packege Image")
    // }
  }


  render() {
    const { userCustomNotificationObj, isLoading, errors, users } = this.state;
    const loading = this.props.userCustomNotifications.loading;


    return (
      <div>
        {
          loading ? <span><i className="text-muted icon-wait"></i> Loading...</span> :
            userCustomNotificationObj ? <div className="animated fadeIn" >
              <Row>
                <Col lg={8}>
                  <form onSubmit={e => this.handleSubmit(e)} >
                    {this.state.formError ? (
                      <Notification type="danger" onCloseBtnClick={e => this.setState({ formError: null })}>
                        {this.state.formError}
                      </Notification>
                    ) : null}
                    <Card>
                      <CardHeader>
                        <div className="row">
                          <div className="col-10">
                            <strong><i className="fa fa-cube pr-1"></i>New Custom Notification</strong>
                          </div>
                          <div className="col-2">
                            <button className="btn btn-success btn-block" disabled={isLoading}>Save</button>
                          </div>
                        </div>

                      </CardHeader>
                      <CardBody>

                        <ToastContainer />
                        <Field label="Sender Type" errors={errors.senderType}>
                          <select name="senderType" value={userCustomNotificationObj.senderType}
                            disabled={isLoading}
                            onChange={e => this.handleChange(e)}>
                            <option value={null}>Sender Type</option>
                            <option value="Push">Push</option>
                            <option value="Email">Email</option>
                          </select>
                        </Field>
                        <Field label="Type" errors={errors.type}>
                          <select name="type" value={userCustomNotificationObj.type}
                            disabled={isLoading}

                            onChange={e => this.handleChange(e)}>
                            <option value={null}>Select Type</option>
                            <option value="All Users">All Users</option>
                            <option value="Specific User">Specific User</option>
                          </select>

                        </Field>
                        {
                          userCustomNotificationObj.type === "Specific User" &&
                          <Field label="User" errors={errors.userId}>
                            <select name="userId" value={userCustomNotificationObj.userId}
                              disabled={isLoading}
                              onChange={e => this.handleChange(e)}>
                              <option value={null}>Select User</option>
                              {users.map((u, i) => <option value={u._id} key={i}>
                                {u.firstName} {u.lastName} | {u.email}
                              </option>)}
                            </select>
                          </Field>
                        }
                        <Field label="Title" errors={errors.title}>
                          <input
                            name="title"
                            type="text"
                            placeholder="Title"
                            value={userCustomNotificationObj.title}
                            disabled={isLoading}
                            onChange={e => this.handleChange(e)}
                          />
                        </Field>
                        <Field label="Body" errors={errors.body}>
                          <textarea
                            name="body"
                            placeholder="Body"
                            value={userCustomNotificationObj.body}
                            disabled={isLoading}
                            onChange={e => this.handleChange(e)}
                          >
                          </textarea>
                        </Field>
                        
                      

                      </CardBody>
                    </Card>
                  </form>
                </Col>
              </Row>
            </div>
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

const connected = connect(mapStateToProps)(UserCustomNotificationManage);
export { connected as UserCustomNotificationManage }; 
