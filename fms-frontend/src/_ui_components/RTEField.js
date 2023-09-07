import React, { Component } from 'react';
import ReactQuill from 'react-quill';
import 'react-quill/dist/quill.snow.css';
import PropTypes from 'prop-types';
export default class RTEField extends Component {
    static propTypes = {
        onChange: PropTypes.func,
        value: PropTypes.string
    };

    state = {
        value: ""
    }
    componentDidMount() {
        this.setState({ value: this.props.value })
    }
    onChange = (value) => {
        this.setState({ value });
        if (this.props.onChange) {
            this.props.onChange(this.state.value);
        }
    };

    onEditorBlur = (previousRange, source) => {
        if (this.props.onChange) {
            this.props.onChange(this.state.value);
        }
    }

    render() {
        return (<ReactQuill theme="snow"
            defaultValue=""
            value={this.state.value}
            onChange={this.onChange}
            onBlur={this.onEditorBlur}
        />

        );
    }
}