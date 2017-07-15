import React, {Component} from 'react';
import axios from 'axios';
import {Link} from 'react-router-dom';

export default class PersonLink extends Component {

    constructor(props) {
        super(props);
        this.state = props;
    }

    getMobile()
    {
            if(typeof this.state.showmobile == 'undefined' || this.state.showmobile==false || typeof this.state.person.mobile == 'undefined' || !this.state.person.mobile)
                return null;
            return ' ' + this.state.person.mobile;
    }

    render() {
        if (this.state.person != undefined)
            return (
                <Link className="person" to={'/people/view/' + this.state.person.id_person.toString()}>
                    {this.state.person.name}{this.getMobile()}
                </Link>
            )
        else
            return null;
        }
    }
