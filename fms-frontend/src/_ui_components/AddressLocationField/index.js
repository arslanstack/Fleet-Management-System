import React, { Component } from 'react';
import Axios from 'axios';
import config from '../../_config';
import { GoogleMap, Marker, withScriptjs, withGoogleMap } from "react-google-maps"
import GoogleMapComponent from './GoogleMapComponent';

export default class AddressLocationField extends Component {
    state = {
        value: ""
    }
    componentDidMount() {
        this.setState({ value: this.props.value })
        if (this.props.value && !this.props.location)
            this.handleInputBlur({ target: { name: this.props.name, value: this.props.value } });
    }
    handleInputChange = ({ target }) => {
        const { name, value } = target;
        let obj = this.props.location ? { [name]: value, [name + "Location"]: this.props.location } : { [name]: value }
        this.triggerOnChange(obj)
    }
    handleInputBlur = ({ target }) => {
        if (!this.props.disabled) {
            const { name, value } = target;
            this.geoCoding(name, value).then(res => {
                this.triggerOnChange(res)
            }).catch(err => {
                console.log(err);
            })
        }

    }

    handleMapClick = (name, latLng) => {
        if (!this.props.disabled)
            this.geoCoding(name, null, latLng).then(res => {
                this.triggerOnChange(res)
            }).catch(err => {
                console.log(err);
            })

    }

    geoCoding = (name, address, latLng = null) => {
        let params = latLng ? { key: config.googleMapAPIKey, latlng: latLng.lat() + "," + latLng.lng() } : { key: config.googleMapAPIKey, address }
        return Axios.get("https://maps.googleapis.com/maps/api/geocode/json", { params }).then(response => {
            let result = response.data.results[0];
            if (result) {
                return {
                    [name]: result.formatted_address,
                    [name + "Location"]: { type: "Point", coordinates: [result.geometry.location.lat, result.geometry.location.lng] }
                }
            } else {
                throw Object.assign({
                    message: "No Result Found"
                })
            }
        })
    }
    triggerOnChange = (obj) => {
        this.setState({ value: obj[Object.keys(obj)[0]] })
        if (this.props.onChange) {
            this.props.onChange(obj);
        }
    }

    render() {
        let { value, name, placeholder, disabled, location, googleMapURL } = this.props;
        return (
            <div>
                <input
                    name={name}
                    type="text"
                    className="form-control"
                    placeholder={placeholder}
                    value={this.state.value}
                    disabled={disabled}
                    onChange={this.handleInputChange}
                    onBlur={e => this.handleInputBlur(e)}
                />
                {
                    location && <GoogleMapComponent
                        googleMapURL={googleMapURL}
                        loadingElement={<div style={{ height: `100%` }} />}
                        containerElement={<div style={{ height: `300px` }} />}
                        mapElement={<div style={{ height: `100%` }} />}>
                        <GoogleMap
                            defaultZoom={config.mapZoom}
                            // defaultCenter={{ lat: location.coordinates[0], lng: location.coordinates[1] }}
                            center={{ lat: location.coordinates[0], lng: location.coordinates[1] }}
                            onClick={d => this.handleMapClick(name, d.latLng)}
                        >
                            <Marker position={{ lat: location.coordinates[0], lng: location.coordinates[1] }} />
                        </GoogleMap>
                    </GoogleMapComponent>
                }
            </div>
        );
    }
}