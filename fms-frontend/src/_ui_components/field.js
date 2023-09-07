import React from 'react';

const Field = ({ errors, label, children }) => (
  <div className="form-group">
    <label className="label">{label}</label>
      {React.cloneElement(children, {
        className: `form-control ${errors ? 'is-danger' : ''}`
      })}
    {errors ? <div className="alert alert-danger">{errors[0]}</div> : null}
  </div>
);

export default Field;
