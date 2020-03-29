import React, {Component} from 'react';
import {Route, Switch,Redirect, Link, withRouter} from 'react-router-dom';
import Favorites from './Favorites';
import Jokes from './Jokes';

class Home extends Component {

    render() {
        return (
            <div>
            <nav className="navbar navbar-expand-lg navbar-dark bg-dark">
            <Link className={"navbar-brand"} to={"/"}> Chuck Norris jokes </Link>
        <div className="collapse navbar-collapse" id="navbarText">
            <ul className="navbar-nav mr-auto">

            <li className="nav-item">
            <Link className={"nav-link"} to={"/jokes"}> Jokes </Link>
            </li>

            <li className="nav-item">
            <Link className={"nav-link"} to={"/favorites"}> Favorites </Link>
            </li>

            </ul>
            </div>
            </nav>
            <Switch>
            <Redirect exact from="/" to="/jokes" />
            <Route path="/favorites" component={Favorites} />
        <Route path="/jokes" component={Jokes} />
        </Switch>
        </div>
    )
    }
}

export default Home;