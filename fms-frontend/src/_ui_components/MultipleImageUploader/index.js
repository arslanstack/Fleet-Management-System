import React, { Component } from "react";
import { ToastContainer, toast } from 'react-toastify';
import 'react-toastify/dist/ReactToastify.css';
import config from "../../_config";
import { authHeader } from "../../_helpers";
import Axios from "axios";
import ImageUploader from "../ImageUploader";
import './style.css';

export default class MultipleImageUploader extends Component {

    state = {
        dataset: null,
        bluePrint: null,
        fetching: true
    }
    loadViaId = null;
    componentDidMount() {
        let { value, bluePrint } = this.props;
        let dataset = [];
        if (!value || (value && value.length === 0)) {
            dataset.push({ isPrimary: true, path: "" });
        } else {
            dataset = value;
        }

        this.setState({ bluePrint: bluePrint, dataset })

    }

    handleChange(index, path) {
        let dataset = JSON.parse(JSON.stringify(this.state.dataset));
        dataset[index].path = path;
        this.setState({ dataset });
        this.props.onChange(dataset.filter(m => m.path !== ""));
    }

    addImageCard = () => {
        let dataset = this.state.dataset;
        dataset.push({ isPrimary: false, path: "" });
        this.setState({ dataset })
    }
    defaultImageCard = (index) => {
        let dataset = this.state.dataset;
        dataset.forEach((d, i) => {
            if (index === i) {
                d.isPrimary = true;
            } else {
                d.isPrimary = false;
            }
        })
        this.setState({ dataset });
        this.props.onChange(dataset.filter(m => m.path !== ""));
    }
    deleteImageCard = (index) => {
        if (index > 0) {
            let dataset = this.state.dataset;
            if (dataset[index].isPrimary)
                this.defaultImageCard(0);
            dataset.splice(index, 1);
            this.setState({ dataset })
            this.props.onChange(dataset.filter(m => m.path !== ""));
        }
    }
    imageCard = (item, index) => {
        return (
            <ImageUploader
                style={{ height: 120, width: 'auto', maxWidth: 120 }}
                name={index}
                value={item.path}
                onChange={filePath => this.handleChange(index, filePath)}
            />
        )
    }
    render() {
        let { label, errors, disabled, placeholder, displayfield, entityAPI } = this.props.bluePrint;
        let { value, name } = this.props;

        let { dataset, fetching } = this.state;

        return (
            <div className="form-group">
                <ToastContainer />
                <label>{label}</label>
                <br />
                <div className="row">
                    {dataset && dataset.map((d, i) => <div class="col-sm-4 noPadding" >
                        <div className="select-outer">
                            <div className="row" style={{ height: 15 }}>
                                <div className="col-8 pt-1" onClick={() => this.defaultImageCard(i)}>
                                    <i className={`primary-icon primary-color fa ${d.isPrimary ? "fa-check-square" : "fa-square-o"} ml-1`}></i>
                                    <span className="ml-1 mt-1 primary-icon primary-color">Primary</span>
                                </div>
                                <div className="col-4" onClick={() => this.deleteImageCard(i)}>
                                    <i className="text-danger fa fa-remove float-right primary-icon m-2"></i>
                                </div>
                            </div>
                            {this.imageCard(d, i)}

                        </div>
                    </div>)}
                    <div class="col-sm-4 noPadding"  onClick={() => this.addImageCard()}>
                        <div className=" select-outer">
                            <div className="circle center">
                                <i className="fa fa-plus add-icon center2"></i>
                            </div>
                        </div>
                    </div>
                    <div className="col-sm-4"></div>
                </div>

                {errors ? <div className="alert alert-danger">{errors[0]}</div> : null}
            </div >
        );
    }
}
