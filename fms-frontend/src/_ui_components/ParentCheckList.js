import React, { Component } from "react";
import { ToastContainer, toast } from 'react-toastify';
import 'react-toastify/dist/ReactToastify.css';
import config from "../_config";
import { authHeader } from "../_helpers";
import Axios from "axios";
export default class ParentCheckList extends Component {

    state = {
        dataset: null,
        bluePrint: null,
        fetching: true
    }
    loadViaId = null;
    componentDidMount() {
        let { value, bluePrint } = this.props;
        let { entityAPI } = bluePrint;
        this.setState({ bluePrint: bluePrint })
        const requestOptions = {
            method: 'GET',
            headers: authHeader()
        };
        fetch(`${config.baseUrl}/api/admin/${entityAPI}`, requestOptions).then(result => result.json()).then(dataset => {
            let newArray = [];
            dataset.forEach(element => {
                let isSelect = false;
                if (value && value.length > 0) {
                    let found = value.find(m => m.obj._id === element._id)
                    if (found) {
                        isSelect = found.isSelect;
                    }
                }
                newArray.push({
                    isSelect,
                    obj: element
                })
            });
            this.setState({ dataset: newArray, fetching: false })
        }).catch(err => {
            toast.error(`Unable to fetch ${entityAPI}`)
            this.setState({ dataset: -1, fetching: false })
        });

    }

    handleChange(index) {
        debugger;
        let dataset = JSON.parse(JSON.stringify(this.state.dataset));
        dataset[index].isSelect = !dataset[index].isSelect;
        this.setState({ dataset });
        // const { value } = target;
        this.props.onChange(dataset.filter(m => m.isSelect));
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
                {fetching && <div className="text-primary">Fething {entityAPI}..</div>}

                {!fetching && dataset && dataset.length > 0 && dataset.map((d, i) => <div className="row" style={{ cursor: "pointer" }} onClick={() => this.handleChange(i)}>
                    <input type="checkbox"
                        className="form-control ml-3 mt-1"
                        style={{ height: 15, width: 15, bottom: 0, cursor: "pointer" }}
                        checked={d.isSelect}
                    />
                    <span style={{ color: "#5C6873" }} className="ml-1">{" - "}{d.obj[displayfield]}</span>
                </div>)
                }
                {!fetching && ((dataset && dataset.length === 0) || !dataset) && <div className="text-info">No {entityAPI} found..</div>}
                {errors ? <div className="alert alert-danger">{errors[0]}</div> : null}
            </div >
        );
    }
}