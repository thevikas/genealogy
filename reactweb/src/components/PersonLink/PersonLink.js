import React, {Component} from 'react';
import axios from 'axios';
import {Link} from 'react-router-dom';

export default class PersonLink extends Component {

    getMobile()
    {
            if(typeof this.props.showmobile == 'undefined' || this.props.showmobile==false || typeof this.props.person.mobile == 'undefined' || !this.props.person.mobile)
                return null;
            return ' ' + this.props.person.mobile;
    }

    render() {
        if (this.props.person.id_person != undefined)
            return (
                <Link className="person" to={'/people/view/' + this.props.person.id_person.toString()}>
                    <i aria-hidden="true" className={"fa " + (this.props.person.gender ? "fa-male" : "fa-female")}></i>
                    {this.props.person.name}{this.getMobile()}
                </Link>
            )
        else
            return null;
        }
    }
