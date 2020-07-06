import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import Axios from "axios";
import Swal from 'sweetalert2';
import {sum} from 'lodash'

class Cart extends Component {
    constructor(props) {
        super(props);
        this.state = {
            cart: [],
            products: [],
            barcode: '',
        };

    this.loadCart = this.loadCart.bind(this);
    this.handlerOnChangeBarcode = this.handlerOnChangeBarcode.bind(this);
    this.handleScanBarcode = this.handleScanBarcode.bind(this);
    this.handleChangeQty = this.handleChangeQty.bind(this)
    this.handleEmptyCart = this.handleEmptyCart.bind(this)

    this.loadProducts = this.loadProducts.bind(this)
    this.handleClickSubmit = this.handleClickSubmit.bind(this)
}    

componentDidMount() {
    // load user cart
    this.loadCart();
    this.loadProducts();
}

handlerOnChangeBarcode(event) {
    const barcode = event.target.value;
    console.log(barcode);
    this.setState({barcode})
}

loadCart() {
    Axios.get("/admin/cart").then(res => {
        const cart = res.data;
        this.setState({ cart });
    });
}

loadProducts() {
    Axios.get('/admin/products').then(res => {
        const products = res.data.data;
        this.setState({ products });
    })
}

handleScanBarcode(event) {
    event.preventDefault();
    const {barcode} = this.state;
    if(!! this.state.barcode){
        Axios.post('/admin/cart', {barcode}).then(res=> {
            this.loadCart();
            this.setState({barcode: ''})
        }).catch(err => {
            Swal.fire(
                'Error!',
                err.response.data.message,
                'error'
            )
        })
    }
}

handleChangeQty (products_id, qty) {
    const cart = this.state.cart.map(c=> {
        if(c.id === products_id) {
            c.pivot.quantity = qty;
        }
        return c;

    })
    
    this.setState({cart})

    Axios.post('/admin/cart/change-qty', {products_id, quantity: qty}).then(res => {

    }).catch(err => [
        Swal.fire(
            'Error!',
            err.response.data.message,
            'error'
        )
    ]);
}

getTotal(cart) {
    const total = cart.map(c => c.pivot.quantity * c.price);
    return sum(total);
}

handleClickDelete(products_id){
    Axios.post('/admin/cart/delete', {products_id, _method: 'DELETE'}).then(res => {
        const cart = this.state.cart.filter(c => c.id !== products_id);
        this.setState({cart});
    })
}

handleEmptyCart() {
    Axios.post('/admin/cart/empty', {_method: 'DELETE'}).then(res => {
        this.setState({cart: []});
    })
}

    addProductToCart(barcode) {
        Axios.post('/admin/cart', {barcode}).then(res=> {
            this.loadCart();
            this.setState({barcode: ''})
        }).catch(err => {
            Swal.fire(
                'Error!',
                err.response.data.message,
                'error'
            )
        })
    }

    handleClickSubmit(){
        Swal.fire({
            title: 'Received ',
            input: 'text',
            inputValue: this.getTotal(this.state.cart), 
            showCancelButton: true,
            confirmButtonText: 'OK',
            showLoaderOnConfirm: true,
            preConfirm: (amount) => {
                Axios.post('/admin/orders', {user_id: this.state.user_id, amount}).then(res => {
                    this.loadCart(); 
                    return res.data;
                }).catch(err => {
                    Swal.fire(err.response.data.message)
                })
            },
            allowOutsideClick: () => !Swal.isLoading()
          }).then((result) => {
            if (result.value) {
                //
            }
          })
        
    }

    render() {
        const {cart, products, barcode} = this.state;
        return (
            <div className='row mt-2'>
                <div className="col-md-8">
                    <div className="itemWrap mt-4">
                        {products.map(p=> (
                        <div onClick={() =>  this.addProductToCart(p.barcode)} key={p.id} className="item shadow-sm">
                            <img src={p.image_url} />
                            <p className="text-center">{p.name}</p>
                        <p className="text-center price">$ {p.price}</p>
                        </div>
                        ))} 
                    </div>
                </div>

                <div className="col-md-4 mt-2">
                    <div className="row first-row">
                        <div className="col">
                            <form onSubmit={this.handleScanBarcode}>
                            <input
                            type="text"
                            placeholder="Code" 
                            autoFocus
                            className="form-control"
                            value={barcode}
                            onChange={this.handlerOnChangeBarcode}    
                            />
                            </form>
                        </div>
                        <div className="col"></div>
                    </div>

                    <div className="user_cart mt-3">
                    <div className="card">
                         <table className="table shadow-sm">
                            <thead className="bg-dark">
                                <tr className="text-center">
                                    <th>Product Name</th>
                                    <th>QTY</th>
                                    <th className="text-right">Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                {cart.map(c => ( 
                                <tr key={c.id}>
                                    <td>{c.name}</td>
                                    <td className="text-center">
                                    <input 
                                    className="qty"
                                    value={c.pivot.quantity} 
                                    onChange={event =>this.handleChangeQty (c.id, event.target.value)}
                                    type="text" 
                                    />
                                    <button 
                                    className="btn btn-danger btn-sm"
                                    onClick={() =>this.handleClickDelete(c.id)}
                                    ><i className="fa fa-trash"></i></button>
                                    </td>
                                    <td className="text-right">$ {(c.price * c.pivot.quantity).toFixed(2)}</td>
                                </tr>
                                ))}
                            </tbody>
                        </table>   
                    </div>
                    <div className="row mt-2 t-sec">
                                <div className="col text-center"><p>Total&nbsp;:</p></div>
                                <div className="col text-right t-price">$ {this.getTotal(cart).toFixed(2)}</div>
                            </div>
                    <div className="row mt-2 t-sec">
                                <div className="col text-center">
                                    <button 
                                    className="btn btn-info"
                                    onClick={this.handleEmptyCart}
                                    >Cancel</button>
                                </div>
                                <div className="col text-right">
                                <button 
                                className="btn btn-danger"
                                onClick={this.handleClickSubmit}
                                >Checkout</button>
                                </div>
                    </div>
                    </div>

                </div>



            </div>
        );
    }
}

export default Cart;

if (document.getElementById("cart")) {
    ReactDOM.render(<Cart />, document.getElementById("cart"));
}
