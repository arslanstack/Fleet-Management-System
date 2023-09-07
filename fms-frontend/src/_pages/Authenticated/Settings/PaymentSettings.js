import React, { Component } from 'react';
// import 'react-toastify/dist/ReactToastify.css';
import { ToastContainer, toast } from 'react-toastify';
import validate from 'validate.js';
import { settingsService } from '../../../_services/settings.service';
import Field from '../../../_ui_components/field';
export default class PaymentSettings extends Component {
    constructor(props) {
        super(props);
        this.state = {
            setting: null,
            errors: {},
            formError: null,
        }
    }
    static get RULES() {
        return {
            secretKey: {
                presence: {
                    allowEmpty: false
                }
            },
            publicKey: {
                presence: {
                    allowEmpty: false
                }
            }
        };
    }
    componentDidMount() {

        // this.settingsService.Add({
        //     secretKey:"test",
        //     publicKey:"test",
        //     status:true
        // }).then(res=>{
        //     alert(JSON.stringify(res));
        // })

        settingsService.Get().then(payments => {            
            this.setState({ setting: payments });
        })
    }
    handleChange({ target }) {
        const { name, value } = target;
        const errors = validate({ [name]: value }, { [name]: PaymentSettings.RULES[name] });
        let obj = this.fillInObject(Object.assign({}, this.state.setting), name, value);
        this.setState({
            setting: obj,
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
    handleSubmit(e) {
        e.preventDefault();
        const errors = validate(this.state.setting, PaymentSettings.RULES);
        debugger;
        if (errors) {
            toast.error("Form data is Invalid")
            return this.setState({ formError: null, errors });
        }
        settingsService.Update(this.state.setting).then(m => {
            //toast.success("Updated"); 
            alert("Updated");
        })
    }
    render() {
        return (
            <section className="section">
                {(!this.state.setting) ?
                    <div className="cLoaderContainer">
                        <div className="cloader"></div>
                    </div> :
                    <div className="container">

                        <form onSubmit={e => this.handleSubmit(e)} >
                            <ToastContainer />
                            <div className="row">
                                <div className="col-sm-6">
                                    <h5>Paystack Payment Settings</h5>
                                    <hr />
                                    <div className="form-group">
                                        <Field label="Secret Key" errors={this.state.errors.secretKey}>
                                            <input
                                                name="secretKey"
                                                type="text"
                                                placeholder="Secret Key"
                                                value={this.state.setting.secretKey}
                                                disabled={this.state.isLoading}
                                                onChange={e => this.handleChange(e)}
                                            />
                                        </Field>
                                    </div>
                                    <div className="form-group">
                                        <Field label="Public Key" errors={this.state.errors.publicKey}>
                                            <input
                                                name="publicKey"
                                                type="text"
                                                placeholder="Public Key"
                                                value={this.state.setting.publicKey}
                                                disabled={this.state.isLoading}
                                                onChange={e => this.handleChange(e)}
                                            />
                                        </Field>
                                    </div>
                                    <div className="form-group">
                                        <button className="btn btn-success btn-block" disabled={this.state.isLoading}>Save</button>
                                    </div>
                                </div>
                             
                            </div>
                        </form>
                    </div>
                }
            </section>
        )
    }
}