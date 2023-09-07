import React, { Component } from "react";
import ImageHelper from "../_helpers/imageHelper";
import { ToastContainer, toast } from 'react-toastify';
import 'react-toastify/dist/ReactToastify.css';
import config from "../_config";
export default class ImageUploader extends Component {
    onChangeHandler = event => {
        var files = event.target.files;
        if (this.maxSelectFile(event) && this.checkMimeType(event) && this.checkFileSize(event)) {
            try {
                let formdata = new FormData();
                formdata.append('image', files[0]);

                var requestOptions = {
                    method: 'POST',
                    body: formdata,
                    redirect: 'follow'
                };

                fetch(config.baseUrl + "/api/upload/image", requestOptions)
                    .then(response => response.json())
                    .then(result => {
                        this.props.onChange(result.filePath);
                    })
                    .catch(error => console.log('error', error));
                // let reader = new FileReader();
                // reader.readAsDataURL(files[0]);
                // reader.onload = (e) => {
                //     // base 64
                //     let file = e.target.result;

                //     let obj = this.fillInObject(Object.assign({}, this.state.packageObj), "image", file);
                //     obj.selectedImage = files[0];

                //     this.setState({
                //         packageObj: obj
                //     });
                // }
            } catch (error) {
                toast.error('Invalid Image')
            }
        }
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

    render() {
        let { label, value, name, errors, style } = this.props;
        return (
            <div className="form-group">
                <ToastContainer />
                <label>{label}</label>
                <br />
                <div className="col-sm-12">
                    <img src={ImageHelper.getImageURL(value)} alt={label}
                        // style={style ? style : { height: 'auto', width: '100%' }} 
                        style={{ height: 'auto', width: '100%' }}
                    />
                </div>
                <div className="col-sm-12">
                    <button type="button" className="btn btn-info text-white" style={{ width: '100%' }} onClick={() => document.getElementById(`image${name}`).click()}>Select Image</button>
                    <input type="file" className="form-control mt-1" name={name} id={`image${name}`} onChange={this.onChangeHandler} style={{ display: 'none' }} />

                </div>

                {errors ? <div className="alert alert-danger">{errors[0]}</div> : null}
            </div>
        );
    }
}