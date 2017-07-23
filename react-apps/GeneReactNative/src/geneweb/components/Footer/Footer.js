import React, {Component} from 'react';
import {Link} from 'react-router-dom';
import moment from 'moment';

import PropTypes from 'prop-types';

export class Footer extends Component {
    render() {
        return (
    		<div className="row-fluid">
    		  <div id="footer" className="span12"> 2013 &copy; Matrix Admin. Brought to you by <a href="http://themedesigner.in">Themedesigner.in</a> </div>
    		</div>
        )
    }
}

export default Footer;
