import React from 'react';
import { ToastContainer } from 'react-toastify';

const Notification = ({ children, type = 'link', onCloseBtnClick = null }) => (
  <div className={`alert alert-${type}`} >
    {typeof onCloseBtnClick === 'function' ? (
      <i className="fas fa-times" style={{color:'red'}} onClick={onCloseBtnClick}></i>
    ) : null}
    {children}
  </div>
);

export default Notification;
