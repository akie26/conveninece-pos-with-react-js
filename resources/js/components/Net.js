import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import Axios from "axios";
import {sum} from 'lodash'

class Invoice extends Component {
    constructor(props) {
        super(props);
        this.state = {
            invoice: [],
        };

        this.loadInvoice = this.loadInvoice.bind(this);
}

componentDidMount() {
    // load user cart
    this.loadInvoice();
}

    loadInvoice() {
        Axios.get("/income/all").then(res => {
            const invoice = res.data;
            this.setState({ invoice });
            // console.log(invoice);
        });
    }

    getTotal(invoice) {
        const total = (invoice.map(c => c.amount));
        var result = total.map(function(x) {
            return Math.abs(x, 10);
        });
        return sum(result);
    }

    render() {
        const {invoice} = this.state;
        return (
           <span className="damnItMan">$ {this.getTotal(invoice).toFixed(2)}</span>
        );
    }
}

export default Invoice;

if (document.getElementById("net")) {
    ReactDOM.render(<Invoice />, document.getElementById("net"));
}