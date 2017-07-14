import React, {Component} from 'react';
import {Link} from 'react-router-dom';
import moment from 'moment';

import PropTypes from 'prop-types';

export class Header extends Component {
    render() {
        return (
    	    <div id="header">
    	      <h1><a href="dashboard.html">Matrix Admin</a></h1>
    	    </div>
        )
    }
}

export default Header;
