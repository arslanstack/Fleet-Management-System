import React, { Component } from "react";
import { Link, withRouter } from "react-router-dom";
import { Card, CardBody, CardHeader, Col, Row, Table } from "reactstrap";
import { apiService } from "../../../_services/api.service";
import { connect } from "react-redux";
import PaginationComponent from "react-reactstrap-pagination";
import Field from '../../../_common/field';
import pluralize from "pluralize";
import ImageHelper from "../../../_helpers/imageHelper";
import Notification from "../../../_common/notification";
import { ToastContainer, toast } from 'react-toastify';
import validate from 'validate.js';
// import { settingsService } from "../../../_services/settings.service";
import DatePicker from "react-datepicker";
import "react-datepicker/dist/react-datepicker.css";
import DateTimePicker from 'react-datetime-picker';
import ImageUploader from "../../../_ui_components/ImageUploader";
import ParentDropDown from "../../../_ui_components/ParentDropDown";
import config from "../../../_config";
import io from 'socket.io-client';
import ParentCheckList from "../../../_ui_components/ParentCheckList";
import MultipleImageUploader from "../../../_ui_components/MultipleImageUploader";
import AddressLocationField from "../../../_ui_components/AddressLocationField";
import RTEField from "../../../_ui_components/RTEField";
import GoogleMapComponent from "../../../_ui_components/AddressLocationField/GoogleMapComponent";
import { GoogleMap, Marker } from "react-google-maps";
import PasswordField from "../../../_ui_components/PasswordField";
const googleMapURL = `https://maps.googleapis.com/maps/api/js?key=${config.googleMapAPIKey}&v=3.exp&libraries=geometry,drawing,places`


// import { useLocation } from 'react-router-dom'


// eslint-disable-next-line no-extend-native
Array.prototype.insert = function (index, item) {
  this.splice(index, 0, item);
};
class DataTable extends Component {
  state = {
    activePagination: {
      pageLoading: true,
      selectedPage: 1,
      pageSize: 10,
      maxPaginationNumbers: 9
    },
    searching: false,
    modelType: null,
    list: [],
    listFiltered: [],
    route: "",
    loaded: false
  };
  componentDidMount() {
    let { location } = this.props;

    let route = pluralize.plural(location.pathname.split("/")[1]);
    this.setState({ route });

    apiService.type(route).then(m => {
      this.setState({ modelType: m });
    })

    this.fetchData(route);



    let socket = io(config.baseUrl, config.socketHeader);
    apiService.type(route).then(modelType => {
      socket.on("new-" + pluralize.singular(modelType.modelDisplayName).toLowerCase(), (m) => {
        this.fetchData(route);
      });
      socket.on("update-" + pluralize.singular(modelType.modelDisplayName).toLowerCase(), (m) => {
        this.fetchData(route);
      });
      socket.on("delete-" + pluralize.singular(modelType.modelDisplayName).toLowerCase(), (m) => {
        this.fetchData(route);
      });
    });

  }
  UNSAFE_componentWillReceiveProps(nextProps) {
    let { location } = nextProps;

    let route = pluralize.plural(location.pathname.split("/")[1]);
    this.setState({ route });

    apiService.type(route).then(m => {
      this.setState({ modelType: m });
    })

    this.fetchData(route);
  }
  fetchData = (route) => {
    const query = new URLSearchParams(this.props.location.search);
    if (query.get("filter")) {
      let filterQuery = JSON.parse(JSON.stringify(query.get("filter")));
      apiService.filter(route, { query: JSON.parse(filterQuery), sortQuery: { dateTime: - 1 } },).then(list => {
        this.setState({ list, listFiltered: list, loaded: true })
      });

    } else {
      apiService.getAll(route).then(list => {
        this.setState({ list, listFiltered: list, loaded: true })
      });
    }
  }
  doSearch = ({ target }) => {
    if (!this.state.searching) {

      this.setState({ searching: true })
      const { value } = target;
      let tempTistFiltered = this.state.list;
      // let listFiltered = JSON.parse(JSON.stringify(this.state.list));
      let searchText = value.toLowerCase();
      let newTempList = [];
      debugger;
      if (tempTistFiltered && tempTistFiltered.length > 0) {
        tempTistFiltered.forEach(item => {
          try {
            Object.keys(this.state.modelType.bluePrint).forEach((attribute, key) => {
              if (!this.state.modelType.bluePrint[attribute].hidden) {
                if ((this.state.modelType.bluePrint[attribute].dataType === "String" ||
                  this.state.modelType.bluePrint[attribute].dataType === "EnumDropDown") &&
                  item[attribute] && item[attribute].toLowerCase().includes(searchText)) {
                  // console.log(item[attribute].toLowerCase());
                  // newTempList.push(item);
                  throw Object.assign(new Error({ status: false }));
                } else if (this.state.modelType.bluePrint[attribute].dataType === "Number" &&
                  item[attribute] && item[attribute].toString().toLowerCase().includes(searchText)) {
                  throw Object.assign(new Error({ status: false }));
                }
              }
            })
          } catch (error) {
            newTempList.push(item);
          }


        })

      }
      this.setState({ listFiltered: newTempList, searching: false })
    }
  }
  handleSelectedActivePage = selectedPage => {
    let activePagination = this.state.activePagination;
    activePagination.selectedPage = selectedPage;
    this.setState({ activePagination });
  };
  generateNavigateParams = (params, obj) => {
    debugger;
    let pramsObj = {}
    params.forEach(p => {
      pramsObj[p.name] = p.field ? obj[p.field] : p.value
    })
    return JSON.stringify(pramsObj);
  }
  restrictNavigationParams = (restrict, obj) => {
    let allow = restrict ? false : true;
    restrict && restrict.forEach((r, i) => {
      if (r.value === obj[r.field]) {
        allow = true;
      }
    })
    return allow;
  }
  render() {
    // const list = categoriesData
    const {
      // list,
      listFiltered, modelType, route, loaded } = this.state;
    return (
      <div className="animated fadeIn">
        <Row>
          <Col xl={12}>
            {modelType &&
              <Card>
                <CardHeader>
                  <i className={modelType.icon}></i> {pluralize.plural(modelType.modelDisplayName)}
                  {modelType.permission && modelType.permission.create &&
                    <Link
                      to={`/${pluralize.singular(route)}/add`}
                      className="btn btn-primary btn-sm"
                      style={{ float: "right" }}
                    >
                      Add New
                    </Link>
                  }
                </CardHeader>
                <CardBody>
                  <Field>
                    <input name="search" type="text" placeholder="Search..." disabled={this.state.searching} onChange={e => this.doSearch(e)} />
                  </Field>
                  <Table responsive hover>
                    <thead>
                      <tr>
                        {Object.keys(modelType.bluePrint).map((th, key) => {
                          if (modelType.bluePrint[th].displayOnHeader && !modelType.bluePrint[th].hidden)
                            return <th scope="col" key={key}>{modelType.bluePrint[th].label}</th>
                          else
                            return null;

                        })}
                        <th key={100} style={{ width: 100 }}>Actions</th>
                      </tr>
                    </thead>
                    <tbody>

                      {loaded && listFiltered.length == 0 && <tr > <td colspan="12" className="text-center">No {pluralize.plural(modelType.modelDisplayName)} found!</td> </tr>}
                      {listFiltered
                        .slice(
                          (this.state.activePagination.selectedPage - 1) *
                          this.state.activePagination.pageSize,
                          this.state.activePagination.selectedPage *
                          this.state.activePagination.pageSize
                        )
                        .map((formObj, index) => (
                          <tr key={formObj._id.toString()}>
                            {
                              Object.keys(modelType.bluePrint).map((td, key) => {
                                if (modelType.bluePrint[td].displayOnHeader && !modelType.bluePrint[td].hidden)
                                  if (modelType.bluePrint[td].dataType === "String" ||
                                    modelType.bluePrint[td].dataType === "EnumDropDown" ||
                                    modelType.bluePrint[td].dataType === "Number" ||
                                    modelType.bluePrint[td].dataType === "AddressBar")
                                    return <td key={key}>{formObj[td]}</td>



                                  else if (modelType.bluePrint[td].dataType === "Image")
                                    return <td key={key}>
                                      <img src={ImageHelper.getImageURL(formObj[td])} alt={td} style={{ height: 70 }} />
                                    </td>

                                  else if (modelType.bluePrint[td].dataType === "Boolean")
                                    return <td key={key}>{formObj[td] ? "Yes" : "No"}</td>

                                  else if (modelType.bluePrint[td].dataType === "ParentDropDown")
                                    return <td key={key}>{formObj[td + "Obj"] ? formObj[td + "Obj"][modelType.bluePrint[td].displayfield] : "Not Selected"}</td>

                                  else if (modelType.bluePrint[td].dataType === "Date" || modelType.bluePrint[td].dataType === "DateTime" || modelType.bluePrint[td].dataType === "DefaultDate")
                                    return <td key={key}>{new Date(formObj[td]).toLocaleDateString()} {new Date(formObj[td]).toLocaleTimeString()}</td>
                                  else
                                    return null;
                                else
                                  return null;
                              })

                            }


                            <td>
                              <Link to={`/${route}/detail/${formObj._id}`} className="mr-2"> <i className="fa fa-info"></i></Link>
                              {modelType.permission && modelType.permission.edit &&
                                <Link to={`/${pluralize.singular(route)}/edit/${formObj._id}`} className="text-warning">
                                  <i className="fa fa-edit"></i>
                                </Link>
                              }
                              {modelType.permission && modelType.permission.delete &&
                                <Link to={`/${route}/delete/${formObj._id}`} className="ml-2 text-danger">
                                  <i className="icon-trash"></i>
                                </Link>
                              }

                              {modelType.actions && modelType.actions.map(action => this.restrictNavigationParams(action.restrict, formObj) && <div className="row">
                                <Link to={`/${action.route}?filter=${this.generateNavigateParams(action.params, formObj)}`} className="ml-2 text-primary">
                                  {action.value}
                                </Link>
                              </div>
                              )}
                            </td>
                          </tr>
                        ))}
                    </tbody>
                  </Table>
                  <PaginationComponent
                    totalItems={listFiltered.length}
                    pageSize={this.state.activePagination.pageSize}
                    onSelect={this.handleSelectedActivePage}
                    maxPaginationNumbers={
                      this.state.activePagination.maxPaginationNumbers
                    }
                    activePage={this.state.activePagination.selectedPage}
                  />
                </CardBody>
              </Card>
            }
          </Col>
        </Row>
      </div>
    );
  }
}

class Detail extends Component {
  state = {
    formObj: null,
    modelType: null,
    loading: true,
    status: false,
    delete: false
  }

  componentDidMount() {
    const { pathname } = this.props.location;
    let { location } = this.props;

    let route = pluralize.plural(location.pathname.split("/")[1]);
    this.setState({ route });

    apiService.type(route).then(m => {
      this.setState({ modelType: m });
    })
    apiService.getSingle(route, this.props.match.params.id).then(formObj => {
      this.setState({ formObj, status: formObj.status, delete: pathname.includes("delete"), loading: false })
    }).catch(e => {
      console.log(e.response)
    })
  }


  render() {
    const { formObj, loading, modelType, route } = this.state;
    return (
      <div>
        {
          loading ? <span><i className="text-muted icon-wait"></i> Loading...</span> :
            formObj && modelType ? <div className="animated fadeIn" >
              <Row>
                <Col lg={8}>
                  <Card>
                    <CardHeader>
                      <strong><i className={`${modelType.icon} pr-1`}></i>{modelType.modelDisplayName}</strong>
                      <br />
                      <Link to={`/${route}`}>Back to List</Link>
                    </CardHeader>
                    <CardBody>
                      <Table striped hover>
                        <tbody>
                          {
                            Object.keys(modelType.bluePrint).map((td, key) => {
                              if (!modelType.bluePrint[td].hidden && modelType.bluePrint[td].dataType) {
                                return <tr key={key}>
                                  <td style={{ width: '30%' }}>{modelType.bluePrint[td].label}</td>

                                  {(modelType.bluePrint[td].dataType === "String" ||
                                    modelType.bluePrint[td].dataType === "EnumDropDown" ||
                                    modelType.bluePrint[td].dataType === "Number") &&
                                    <td key={key}>{formObj[td]}</td>
                                  }
                                  {(modelType.bluePrint[td].dataType === "PasswordHash") &&
                                    <td key={key} >
                                      *******
                                  </td>
                                  }

                                  {(modelType.bluePrint[td].dataType === "RichText") &&
                                    <td key={key} >
                                      <div dangerouslySetInnerHTML={{ __html: formObj[td] }}></div>
                                    </td>
                                  }
                                  {(modelType.bluePrint[td].dataType === "AddressBar") &&
                                    <td key={key}>
                                      <div classNme="row">
                                        <div className="col-sm-12">{formObj[td]}</div>
                                        <div className="col-sm-12 mt-2">
                                          <GoogleMapComponent
                                            googleMapURL={googleMapURL}
                                            loadingElement={<div style={{ height: `100%` }} />}
                                            containerElement={<div style={{ height: `300px` }} />}
                                            mapElement={<div style={{ height: `100%` }} />}>
                                            <GoogleMap
                                              defaultZoom={config.mapZoom}
                                              defaultCenter={{ lat: formObj[td + "Location"].coordinates[0], lng: formObj[td + "Location"].coordinates[1] }}
                                            >
                                              <Marker position={{ lat: formObj[td + "Location"].coordinates[0], lng: formObj[td + "Location"].coordinates[1] }} />
                                            </GoogleMap>
                                          </GoogleMapComponent>
                                        </div>
                                      </div>
                                    </td>
                                  }

                                  {(modelType.bluePrint[td].dataType === "Image") && <td key={key}>
                                    <img src={ImageHelper.getImageURL(formObj[td])} alt={td} style={{ height: 100 }} />
                                  </td>}

                                  {(modelType.bluePrint[td].dataType === "MultipleImages") && <td key={key}>
                                    <div className="row">
                                      {formObj[td].map(item => <div className="col-sm-4">
                                        <img src={ImageHelper.getImageURL(item.path)} alt={td} style={{ width: '100%', height: 'auto' }} />
                                      </div>
                                      )}
                                    </div>
                                  </td>}

                                  {(modelType.bluePrint[td].dataType === "Boolean") &&
                                    <td key={key}>{formObj[td] ? "Yes" : "No"}</td>
                                  }


                                  {(modelType.bluePrint[td].dataType === "ParentDropDown") &&
                                    <td key={key}>{formObj[td + "Obj"]?formObj[td + "Obj"][modelType.bluePrint[td].displayfield]:"Not Selected"}</td>
                                  }

                                  {(modelType.bluePrint[td].dataType === "ParentCheckList") &&
                                    <td key={key}>
                                      {formObj[td].map(li => <li>
                                        {li.obj[modelType.bluePrint[td].displayfield]}
                                      </li>)}
                                    </td>
                                  }

                                  {(modelType.bluePrint[td].dataType === "Date" || modelType.bluePrint[td].dataType === "DateTime" || modelType.bluePrint[td].dataType === "DefaultDate") &&
                                    <td key={key}>{new Date(formObj[td]).toLocaleDateString()} {new Date(formObj[td]).toLocaleTimeString()}</td>
                                  }

                                </tr>
                              } else
                                return null;
                            })
                          }

                          {this.state.delete &&
                            <tr>
                              <td>
                                Comfirmation:
                              </td>
                              <td>
                                <button className="btn btn-danger btn-sm" type="button" onClick={() => { apiService.delete(route, formObj._id).then(d => { this.props.history.push(`/${route}`) }) }}>
                                  <i className="icon-trash"></i> Delete
                                </button>
                                <button className="btn btn-info btn-sm text-white ml-1" type="button" onClick={() => { this.props.history.push(`/${route}`) }}>Cancel</button>
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

class Manage extends Component {
  state = {
    formObj: null,
    validationRule: null,
    errors: {},
    formError: null,
    loaded: 0,
    pageLoading: true,
    isLoading: true,
    modelType: null,
    single: false
  }

  componentDidMount() {
    let { location } = this.props;
    let route = pluralize.plural(location.pathname.split("/")[1]);
    this.setState({ route });

    const query = new URLSearchParams(this.props.location.search);
    if (query.get("single")) {
      this.setState({ single: true })
    }


    apiService.type(route).then(modelType => {
      //Define Validation Rule
      let validationRule = {};
      Object.keys(modelType.bluePrint).forEach((attribute, key) => {
        if (!modelType.bluePrint[attribute].hidden && (modelType.bluePrint[attribute].dataType !== "Boolean" || modelType.bluePrint[attribute].dataType !== "DefaultDate")) {

          if (modelType.bluePrint[attribute].required) {
            validationRule[attribute] = { presence: { allowEmpty: false } }
          }
          if (modelType.bluePrint[attribute].dataType === "Number") {
            validationRule[attribute] = { presence: { allowEmpty: false }, format: "\\d*\\.?\\d+" }
          }
        }
      });
      this.setState({ modelType, validationRule });
      if (this.props.match.params.id) {
        apiService.getSingle(route, this.props.match.params.id).then(formObj => {
          Object.keys(modelType.bluePrint).forEach((attribute, key) => {
            if (!modelType.bluePrint[attribute].hidden)
              if (modelType.bluePrint[attribute].dataType === "DateTime" || modelType.bluePrint[attribute].dataType === "Date") {
                formObj[attribute] = new Date(formObj[attribute]);
              }
              else if (modelType.bluePrint[attribute].dataType === "RichText")
                formObj[attribute] = (!formObj[attribute]) ? "" : formObj[attribute];
              else if (modelType.bluePrint[attribute].dataType === "Number")
                formObj[attribute] += "";

            Object.keys(modelType.bluePrint).forEach((at, indx) => {
              if (modelType.bluePrint[at].dataType && modelType.bluePrint[at].loadVia === attribute) {
                modelType.bluePrint[at]["loadViaId"] = formObj[attribute];
              }
            });

          });

          this.setState({ formObj, isLoading: false })
        }).catch(m => {
          this.props.history.push(`/${route}`)
        })
      } else {
        let formObj = {
          _id: ""
        }
        Object.keys(modelType.bluePrint).forEach((attribute, key) => {
          if (!modelType.bluePrint[attribute].hidden && (modelType.bluePrint[attribute].dataType === "Date" || modelType.bluePrint[attribute].dataType === "DefaultDate")) {
            formObj[attribute] = new Date();
          } else {
            formObj[attribute] = modelType.bluePrint[attribute].default;
          }
        });
        this.setState({ formObj, isLoading: false });
      }
    })


  }

  convertAllParametersToString(ad) {
    for (var prop in ad) {
      ad[prop] += "";
    }
    return ad;
  }
  static get RULES() {
    return {
      title: {
        presence: {
          allowEmpty: false
        }
      }
    };
  }
  handleChange({ target }) {
    const { name, value } = target;
    const errors = validate({ [name]: value }, { [name]: this.state.validationRule[name] });
    let obj = this.fillInObject(Object.assign({}, this.state.formObj), name, value);
    this.setState({
      formObj: obj,
      errors: Object.assign(
        {},
        this.state.errors,
        errors ? errors : { [name]: undefined }
      )
    });
  }
  handleChageCustom = (name, value) => {
    const errors = validate({ [name]: value }, { [name]: this.state.validationRule[name] });
    let obj = this.fillInObject(Object.assign({}, this.state.formObj), name, value);
    this.setState({
      formObj: obj,
      errors: Object.assign(
        {},
        this.state.errors,
        errors ? errors : { [name]: undefined }
      )
    });
  }
  handleChangeBoolean({ target }) {
    const { name } = target;
    let obj = this.fillInObject(Object.assign({}, this.state.formObj), name, !this.state.formObj[name]);
    this.setState({
      formObj: obj
    });
  }

  fillInObject(obj, name, value) {
    // console.log(value);

    obj[name] = value;
    return obj;
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
    // if (this.state.formObj.image) {
    const errors = validate(this.state.formObj, this.state.validationRule);
    debugger;
    if (errors) {
      toast.error("Form data is Invalid")
      return this.setState({ formError: null, errors });
    }

    this.setState({ isLoading: true }, () => {
      if (!this.state.formObj._id) {
        apiService.add(this.state.route, this.state.formObj).then(res => {
          if (!this.state.single)
            this.props.history.push(`/${this.state.route}`)

        }).catch(err => {
          toast.error(err.response.data.message);
          this.setState({ isLoading: false })
        })
      } else {
        apiService.update(this.state.route, this.state.formObj, this.state.formObj._id).then(res => {
          if (!this.state.single) {
            this.props.history.push(`/${this.state.route}`)
          } else {
            toast.success("Successfully Updated!");
            this.setState({ isLoading: false })
          }

        }).catch(err => {
          toast.error(err.response.data.message);
          this.setState({ isLoading: false })
        })
      }
    })



    // } else {
    //   toast.error("Please Upload Packege Image")
    // }
  }
  render() {
    const { formObj, isLoading, errors, modelType, route, single } = this.state;

    return (
      <div>
        {
          isLoading ? <span><i className="text-muted icon-wait"></i> Loading...</span> :
            formObj ? <div className="animated fadeIn" >
              <Row>
                <Col lg={6}>
                  <form onSubmit={e => this.handleSubmit(e)} >
                    <ToastContainer></ToastContainer>
                    {this.state.formError ? (
                      <Notification type="danger" onCloseBtnClick={e => this.setState({ formError: null })}>
                        {this.state.formError}
                      </Notification>
                    ) : null}
                    <Card>
                      <CardHeader>
                        <div className="row">
                          <div className={"col-7"}>
                            <strong><i className={`${modelType.icon} pr-1`}></i>{modelType.modelDisplayName} Manage</strong>
                          </div>
                          <div className={"col-5"}>
                            {
                              !single && <Link to={`/${route}`} className="btn btn-danger btn-sm mr-1" style={{ width: 60 }} disabled={isLoading}>Cancel</Link>
                            }

                            <button className={`btn btn-success btn-sm ${single ? "btn-block" : ""}`} style={{ width: single ? null : 60 }} disabled={isLoading}>Save</button>

                          </div>
                        </div>

                      </CardHeader>
                      <CardBody>
                        {
                          Object.keys(modelType.bluePrint).map((attribute, key) => {
                            if (!modelType.bluePrint[attribute].hidden && modelType.bluePrint[attribute].dataType !== "DefaultDate") {
                              if (modelType.bluePrint[attribute].dataType === "String" || modelType.bluePrint[attribute].dataType === "Number") {
                                return <Field label={modelType.bluePrint[attribute].label} errors={errors[attribute]} key={key}>
                                  <input
                                    name={attribute}
                                    // type={modelType.bluePrint[attribute].dataType === "String" ? "text" : "number"}
                                    type="text"
                                    placeholder={modelType.bluePrint[attribute].placeholder}
                                    value={formObj[attribute]}
                                    disabled={isLoading}
                                    onChange={e => this.handleChange(e)}
                                  />
                                </Field>
                              }
                              else if (modelType.bluePrint[attribute].dataType === "PasswordHash") {
                                return <Field label={modelType.bluePrint[attribute].label} errors={errors[attribute]} key={key}>
                                  <PasswordField
                                    name={attribute}
                                    // type={modelType.bluePrint[attribute].dataType === "String" ? "text" : "number"}
                                    placeholder={modelType.bluePrint[attribute].placeholder}
                                    value={formObj[attribute]}
                                    disabled={isLoading}
                                    onChange={value => this.handleChageCustom(attribute, value)}

                                  />
                                </Field>
                              } else if (modelType.bluePrint[attribute].dataType === "RichText") {
                                return <div className="form-group">
                                  <label>{modelType.bluePrint[attribute].label}</label>
                                  <RTEField
                                    value={formObj[attribute]}
                                    onChange={value => this.handleChageCustom(attribute, value)}
                                  />
                                </div>
                              } else if (modelType.bluePrint[attribute].dataType === "AddressBar") {
                                return <Field label={modelType.bluePrint[attribute].label} errors={errors[attribute]} key={key}>
                                  <AddressLocationField
                                    name={attribute}
                                    type={modelType.bluePrint[attribute].dataType === "String" ? "text" : "number"}
                                    placeholder={modelType.bluePrint[attribute].placeholder}
                                    value={formObj[attribute]}
                                    location={formObj[attribute + "Location"]}
                                    disabled={isLoading}
                                    googleMapURL={googleMapURL}
                                    onChange={(res) => {
                                      this.handleChageCustom(attribute, res[attribute])
                                      if (res[attribute + "Location"])
                                        this.handleChageCustom(attribute + "Location", res[attribute + "Location"])
                                    }}

                                  />
                                </Field>
                              } else if (modelType.bluePrint[attribute].dataType === "EnumDropDown") {
                                return <Field label={modelType.bluePrint[attribute].label} errors={errors[attribute]} key={key}>
                                  <select
                                    name={attribute}
                                    value={formObj[attribute]}
                                    disabled={isLoading}
                                    onChange={e => this.handleChange(e)}
                                  >
                                    <option value={null}>{modelType.bluePrint[attribute].placeholder}</option>
                                    {modelType.bluePrint[attribute].enum.map(en => <option value={en}>{en}</option>)}
                                  </select>
                                </Field>
                              } else if (modelType.bluePrint[attribute].dataType === "ParentDropDown") {
                                return <ParentDropDown
                                  key={key}
                                  name={attribute}
                                  bluePrint={modelType.bluePrint[attribute]}
                                  value={formObj[attribute]}
                                  errors={errors[attribute]}
                                  disabled={isLoading}
                                  onChange={parentId => {
                                    Object.keys(modelType.bluePrint).forEach((at, indx) => {
                                      if (modelType.bluePrint[at].dataType && modelType.bluePrint[at].loadVia === attribute) {
                                        modelType.bluePrint[at]["loadViaId"] = parentId;
                                      }
                                    });
                                    this.setState({ modelType });
                                    this.handleChageCustom(attribute, parentId);
                                  }}
                                />

                              } else if (modelType.bluePrint[attribute].dataType === "ParentCheckList") {
                                return <ParentCheckList
                                  key={key}
                                  name={attribute}
                                  bluePrint={modelType.bluePrint[attribute]}
                                  value={formObj[attribute]}
                                  errors={errors[attribute]}
                                  disabled={isLoading}
                                  onChange={parentId => this.handleChageCustom(attribute, parentId)}
                                />
                              } else if (modelType.bluePrint[attribute].dataType === "MultipleImages") {
                                return <MultipleImageUploader
                                  key={key}
                                  name={attribute}
                                  bluePrint={modelType.bluePrint[attribute]}
                                  value={formObj[attribute]}
                                  errors={errors[attribute]}
                                  disabled={isLoading}
                                  onChange={parentId => this.handleChageCustom(attribute, parentId)}
                                />
                              } else if (modelType.bluePrint[attribute].dataType === "Image") {
                                return <div className="col-sm-6">
                                  <ImageUploader
                                    key={key}
                                    name={attribute}
                                    label={modelType.bluePrint[attribute].label}
                                    placeholder={modelType.bluePrint[attribute].placeholder}
                                    value={formObj[attribute]}
                                    errors={errors[attribute]}
                                    onChange={filePath => this.handleChageCustom(attribute, filePath)} />
                                </div>
                              } else if (modelType.bluePrint[attribute].dataType === "Boolean") {
                                return <div className="form-group" key={key}>
                                  <label>{modelType.bluePrint[attribute].label}: </label>
                                  <input
                                    name={attribute}
                                    type={"checkbox"}
                                    className="ml-3 mt-1"
                                    placeholder={modelType.bluePrint[attribute].placeholder}
                                    checked={formObj[attribute]}
                                    disabled={isLoading}
                                    onChange={e => this.handleChangeBoolean(e)}
                                  />
                                </div>
                              } else if (modelType.bluePrint[attribute].dataType === "Date") {
                                return <Field label={modelType.bluePrint[attribute].label} labelBr={true} errors={errors[attribute]} key={key}>
                                  <DatePicker
                                    selected={formObj[attribute]}
                                    onChange={date => this.handleChageCustom(attribute, date)}
                                  />
                                </Field>
                              } else if (modelType.bluePrint[attribute].dataType === "DateTime") {
                                // return <Field label={modelType.bluePrint[attribute].label} labelBr={true} errors={errors[attribute]}>
                                return <div className="form-group">
                                  <label>{modelType.bluePrint[attribute].label}</label>
                                  <br />
                                  <DateTimePicker
                                    value={formObj[attribute]}
                                    onChange={date => this.handleChageCustom(attribute, date)}
                                    key={key}
                                  />
                                </div>
                                // </Field>
                              } else
                                return null;
                            } else
                              return null;
                          })
                        }
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
  const { categories } = state;
  // const { token, admin } = authentication;
  return {
    categories
  };
}

const connectedDataTable = connect(mapStateToProps)(withRouter(DataTable));
const connectedDetail = connect(mapStateToProps)(withRouter(Detail));
const connectedManage = connect(mapStateToProps)(withRouter(Manage));
export { connectedDataTable as DataTable, connectedDetail as Detail, connectedManage as Manage };

