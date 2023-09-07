import React from "react";
import { Route, Redirect } from "react-router-dom";

export const AnonymousRoute = ({ component: Component, ...rest }) => (
  <Route
    {...rest}
    render={props =>
      localStorage.getItem("token") ? (
        <Redirect
          to={{ pathname: "/dashboard", state: { from: props.location } }}
        />
      ) : (
        <Component {...props} />
      )
    }
  />
);
