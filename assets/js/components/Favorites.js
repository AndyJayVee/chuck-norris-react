import React, {Component} from 'react';
import axios from 'axios';

class Favorites extends Component {
    constructor() {
        super();
        this.state = { favorites: [], removedFavorites: [], loading: true};
        this.removeFavorite.bind(this);
    }

    componentDidMount() {
        this.getFavorites();
    }

    getFavorites() {
        axios.get("http://localhost:8000/api/favorites").then(result => {
            const favorites = result.data;
            this.setState({ favorites, loading: false })
        })
    }

    removeFavorite(id) {
        const newState = this.state;
        const index = newState.favorites.findIndex(a => a.joke_id === id);

        if (index === -1) return;
        newState.favorites.splice(index, 1);

        this.setState(newState); // This will update the state and trigger a rerender of the components
    }

    handleRemoveClick(jokeId) {
        const requestOptions = {
            method: 'GET'
            //TODO: change to DELETE, DELETE method has special treatment
        };
        fetch("http://localhost:8000/api/remove/" + jokeId, requestOptions)
        .then(response => {
            if (response.status == "200") {
                this.removeFavorite(jokeId);
            } else if (response.status == "404")  {
                alert("Joke is not a favorite.");
            } else alert("Error saving joke");
            this.setState({ favorites, loading: false })
        })
    }

    render() {
        const loading = this.state.loading;
        return(
            <div>
                <section className="row-section">
                    <div className="container">
                        <div className="row">
                            <h2 className="text-center"><span>List of favorites</span></h2>
                        </div>
                        {loading ? (
                            <div className={'row text-center'}>
                                <span className="fa fa-spin fa-spinner fa-4x"></span>
                            </div>
                        ) : (
                            <div className={'row'}>
                                { this.state.favorites.map(favorite =>
                                    <div className="col-md-10 offset-md-1 row-block" key={favorite.id}>
                                        <ul id="sortable">
                                            <li>
                                                <div className="media">
                                                    <div className="media-body">
                                                        <h4>{favorite.joke_id}</h4>
                                                        <p>{favorite.joke.replace(/&quot;/g, '"')}</p>
                                                    </div>
                                                    <div className="media-right align-self-center">
                                                        <button onClick={() => { this.handleRemoveClick(favorite.joke_id) }} className="btn btn-default" >Remove</button>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                )}
                            </div>
                        )}
                    </div>
                </section>
            </div>
        )
    }
}
export default Favorites;
