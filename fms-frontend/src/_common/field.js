import React from 'react';
const Field = ({ errors, label, children ,labelBr}) => (
    <div className="form-group">
        {label && <label className="label">{label}</label>}
        {labelBr && <br/>}
        {React.cloneElement(children, {
            className: `form-control ${errors ? 'is-danger' : ''}`
        })}
        {errors ? <div className="alert alert-danger">{errors[0]}</div> : null}
    </div>
);

export default Field;
