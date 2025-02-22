import ProductItem from '@/Components/App/ProductItem';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { PageProps, PagiantionProps, Product } from '@/types';
import { Head, Link } from '@inertiajs/react';

export default function Welcome({
    products
}: PageProps<{ products: PagiantionProps<Product> }>) {



    return (
        <AuthenticatedLayout>
            <Head title="Welcome" />
            <div
                className="hero min-h-screen"
                style={{
                    backgroundImage: "url(https://img.daisyui.com/images/stock/photo-1507358522600-9f71e620c44e.webp)",
                }}>
                <div className="hero-overlay bg-opacity-60"></div>
                <div className="hero-content text-neutral-content text-center">
                    <div className="max-w-md">
                        <h1 className="mb-5 text-5xl font-bold">Hello there</h1>
                        <p className="mb-5">
                            Welcome to TM Store for Laravel 11 + React
                        </p>
                        <button className="btn btn-primary">Get Started</button>
                    </div>
                </div>
            </div>
            <div className="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3 p-8">
                {products.data.map(product => (
                    <ProductItem product={product} key={product.id} />
                ))}
            </div>
        </AuthenticatedLayout>
    );
}
