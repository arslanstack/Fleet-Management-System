import React, { Component } from "react";
import { HashRouter, Route, Switch, Router } from "react-router-dom";
import "@coreui/icons/css/coreui-icons.css"
import "flag-icon-css/css/flag-icon.min.css"
import "font-awesome/css/font-awesome.min.css"
import "simple-line-icons/css/simple-line-icons.css"
import 'bootstrap/dist/css/bootstrap.min.css';
import '@coreui/coreui/dist/css/coreui.min.css'
// import { renderRoutes } from 'react-router-config';
// import "./App.scss";
import { AnonymousRoute } from "./_components/AnonymousRoute";
import { AuthenticatedRoute } from "./_components/AuthenticatedRoute";

import { Provider } from "react-redux";
import { store } from "./_helpers/store";
import { DefaultLayout } from "./containers/DefaultLayout/DefaultLayout";
import { history } from "./_helpers";
// import Translation from './_helpers/translation-i18';
import { useTranslation } from 'react-i18next';
import { Login } from "./_pages/Anonymous/Login/Login";

const loading = () => (
  <div className="animated fadeIn pt-3 text-center">Loading...</div>
);

// Containers
// const DefaultLayout = React.lazy(() => import('./containers/DefaultLayout'));

// Pages
// const Login = React.lazy(() => import('./views/Pages/Login'));
// const Register = React.lazy(() => import('./views/Pages/Register'));
// const Page404 = React.lazy(() => import('./views/Pages/Page404'));
// const Page500 = React.lazy(() => import('./views/Pages/Page500'));

function App() {
  const { t } = useTranslation();
  return (
    <Provider store={store}>
      <HashRouter history={history}>
        {/* <Router history={history}> */}
        <React.Suspense fallback={loading()}>
          <Switch>
            <AnonymousRoute
              path="/login"
              name="Login Page"
              component={Login}
            />
            {/* <Route exact path="/login" name="Login Page" render={props => <Login {...props}/>} /> */}
            {/* <Route exact path="/register" name="Register Page" render={props => <Register {...props}/>} /> */}
            {/* <Route exact path="/404" name="Page 404" render={props => <Page404 {...props} />} />
            <Route exact path="/500" name="Page 500" render={props => <Page500 {...props} />} /> */}
            <AuthenticatedRoute
              path="/"
              name="Admin"
              component={DefaultLayout}
            />


            {/* <Route path="/" name="Home" render={props => <DefaultLayout {...props} />} /> */}
          </Switch>
        </React.Suspense>
        {/* </Router> */} 
      </HashRouter>
    </Provider>
  );
}

export default App;
