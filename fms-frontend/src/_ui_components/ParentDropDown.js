import React, { Component } from "react";
import { ToastContainer, toast } from 'react-toastify';
import 'react-toastify/dist/ReactToastify.css';
import config from "../_config";
import { authHeader } from "../_helpers";
import Axios from "axios";
export default class ParentDropDown extends Component {

    state = {
        dataset: null,
        bluePrint: null,
        fetching: true
    }
    loadViaId = null;
    componentDidMount() {
        let { entityAPI, loadVia, loadViaId } = this.props.bluePrint;
        this.setState({ bluePrint: this.props.bluePrint })

        if (!loadVia) {
            const requestOptions = {
                headers: authHeader()
            };
            if (this.props.bluePrint.entityFilter) {
                Axios.post(`${config.baseUrl}/api/admin/${entityAPI}/filter`, { query: this.props.bluePrint.entityFilter }, requestOptions)
                    .then(res => res.data)
                    .then(handleSuccess)
                    .catch(handleError);
            }
            else {
                Axios.get(`${config.baseUrl}/api/admin/${entityAPI}`, requestOptions)
                    .then(res => res.data)
                    .then(handleSuccess)
                    .catch(handleError);
            }
            let that = this;
            function handleSuccess(dataset) {
                that.setState({ dataset, fetching: false })
            }
            function handleError(err) {
                toast.error(`Unable to fetch ${entityAPI}`)
                that.setState({ dataset: -1, fetching: false })
            }
        } else if (loadVia && loadViaId) {
            debugger;
            this.loadByParent(this.props.bluePrint)
        } else {
            this.setState({ fetching: false })
        }
    }
    componentWillReceiveProps(nextProps) {
        // You don't have to do this check first, but it can help prevent an unneeded render

        let { loadVia, loadViaId } = nextProps.bluePrint;

        if ((loadViaId && loadViaId !== this.loadViaId && loadVia !== undefined)) {
            this.loadByParent(nextProps.bluePrint, true)
        }

    }
    loadByParent = (bluePrint, setNull = false) => {
        let { entityAPI, loadVia, loadViaId } = bluePrint;
        this.setState({ fetching: true })
        this.loadViaId = loadViaId;
        const requestOptions = {
            headers: authHeader()
        };
        Axios.post(`${config.baseUrl}/api/admin/${entityAPI}/filter`, { query: { [loadVia]: loadViaId } }, requestOptions).then(dataset => {
            if (setNull) this.handleChange({ target: { value: null } });
            this.setState({ dataset: dataset.data, bluePrint: bluePrint, fetching: false })

        }).catch(err => {
            toast.error(`Unable to fetch ${entityAPI}`)
            this.setState({ dataset: -1, bluePrint: bluePrint, fetching: false })
        });
    }
    handleChange({ target }) {
        const { value } = target;
        this.props.onChange(value);
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
                {!fetching && dataset && dataset.length > 0 && <div>

                    <select
                        className="form-control"
                        name={name}
                        value={value}
                        disabled={disabled}
                        onChange={e => this.handleChange(e)}
                    >
                        <option value={null}>{placeholder}</option>
                        {dataset.map && dataset.map(d => <option value={d._id}>{d[displayfield]}</option>)}
                    </select>
                </div>
                }
                {!fetching && ((dataset && dataset.length === 0) || !dataset) && <div className="text-info">No {entityAPI} found..</div>}
                {errors ? <div className="alert alert-danger">{errors[0]}</div> : null}
            </div>
        );
    }
}