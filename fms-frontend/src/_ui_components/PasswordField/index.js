import React, { Component } from 'react';
import Axios from 'axios';
import config from '../../_config';

export default class PasswordField extends Component {
    state = {
        value: ""
    }
    componentDidMount() {
        this.setState({ value: this.props.value })
        if (this.props.value)
            this.handleInputChange({ target: { name: this.props.name, value: this.props.value } });
    }
    handleInputChange = ({ target }) => {
        if (!this.props.disabled) {
            const { name, value } = target;
            this.triggerOnChange(value)
        }
    }
    triggerOnChange = (value) => {
        this.setState({ value: value })
        if (this.props.onChange) {
            this.props.onChange(value);
        }
    }
    render() {
        let { value, name, placeholder, disabled } = this.props;
        return (
            <div>
                <input
                    name={name}
                    type="password"
                    className="form-control"
                    placeholder={placeholder}
                    // value={this.state.value}
                    disabled={disabled}
                    onChange={this.handleInputChange}
                />

            </div>
        );
    }
}