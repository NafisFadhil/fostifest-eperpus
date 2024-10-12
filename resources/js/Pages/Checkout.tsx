import SubPageLayout from "@/Layouts/SubPageLayout";
import React from "react";
import { FaStar } from "react-icons/fa6";

type Props = {};

const Checkout = (props: Props) => {
    return (
        <SubPageLayout>
            <div className="w-full relative">
                {/* Header */}
                <header className="w-full px-4 py-16 text-center prose prose-invert prose-lg max-w-none bg-primary">
                    <h2 className="">Pinjam Buku</h2>
                </header>

                <main className="w-full p-4">
                    <section className="w-full bg-gray-100 prose">
                        {/* Book Cover */}
                        <div className="size-full max-w-screen-lg mx-auto flex flex-col justify-center items-center p-4 gap-1">
                            {/* Image */}
                            <div className="max-w-[150px] h-auto">
                                <img
                                    src="/asset/images/cover-buku.jpeg"
                                    alt=""
                                    className="block w-full h-auto aspect-auto rounded-md shadow-lg shadow-black/50 my-3"
                                />
                            </div>
                            {/* Title */}
                            <div className="flex-1 flex flex-col gap-1 text-center">
                                <p className="text-lg m-0"> My Jaspier June </p>
                                <p className="text-sm opacity-75 m-0">
                                    By Jaspier June
                                </p>
                                <div className="flex flex-row flex-wrap justify-center items-center gap-2 text-xs">
                                    <span className="bg-black/10 rounded-full px-4 py-1">
                                        Action
                                    </span>
                                    <span className="bg-black/10 rounded-full px-4 py-1">
                                        Adventure
                                    </span>
                                    <span className="bg-black/10 rounded-full px-4 py-1">
                                        Romance
                                    </span>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section className="">
                        <div className="w-full-max-w-screen-lg prose">
                            <h1> Form Peminjaman </h1>

                            <form action="" method="post">
                                <div className="w-full flex flex-col">
                                    <label htmlFor="">Nama Peminjam</label>
                                    <input
                                        type="text"
                                        className="w-full border border-gray-200 rounded-md"
                                    />
                                </div>
                                <div className="w-full flex flex-col">
                                    <label htmlFor="">Tanggal Pesan</label>
                                    <input
                                        type="date"
                                        className="w-full border border-gray-200 rounded-md"
                                    />
                                </div>
                            </form>
                        </div>
                    </section>
                </main>
            </div>
        </SubPageLayout>
    );
};

export default Checkout;
