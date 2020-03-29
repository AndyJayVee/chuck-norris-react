import React, {Component} from 'react';
import axios from 'axios';

class Jokes extends Component {
    constructor() {
        super();
        this.state = { jokes: [], loading: true, ButtonActive: true, savedJokes: [], buttonText: "Saved"}
    }

    componentDidMount() {
        this.getJokes();
    }

    getJokes() {
        axios.get("http://api.icndb.com/jokes/random/10").then(result => {
            const jokes = result.data.value;
            this.setState({ jokes, loading: false })
        })
    }

    handleSaveClick(jokeId) {
        const requestOptions = {
            method: 'GET'
            //TODO: change to PUT, PUT method has special treatment
        };
        fetch("http://localhost:8000/api/save/" + jokeId, requestOptions)
            .then(response => {
                if (response.status == "200") {
                    alert("Joke saved");
                } else if (response.status == "422")  {
                    alert("Can't save more than ten jokes");
                } else if (response.status == "409") {
                    alert("Joke already saved");
                } else alert("Error saving joke");
                return response.json();
            })
    }

    render() {
        const loading = this.state.loading;
        return (
            <div>
                <section className="row-section">
                    <div className="container">
                        <div className="row">
                            <h2 className="text-center">
                                <span>List of jokes</span>
                                <button onClick={() => { this.getJokes() }} className="btn btn-default" >New jokes</button>
                            </h2>
                        </div>
                        {loading ? (
                            <div className={'row text-center'}>
                                <span className="fa fa-spin fa-spinner fa-4x"></span>
                            </div>
                        ) : (
                            <div className={'row'}>
                                {this.state.jokes.map(joke =>
                                    <div className="col-md-10 offset-md-1 row-block" key={joke.id}>
                                        <ul id="sortable">
                                            <li>
                                                <div className="media">
                                                    <div className="media-body">
                                                        <h4>{joke.id}</h4>
                                                        <p>{joke.joke.replace(/&quot;/g, '"')}</p>
                                                    </div>
                                                    <div className="media-right align-self-center">
                                                        <button onClick={() => { this.handleSaveClick(joke.id) }} className="btn btn-default">Save</button>
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

export default Jokes;
