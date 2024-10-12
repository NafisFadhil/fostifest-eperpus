import Footer from "@/Components/Footer";
import React from "react";
import { FaStar } from "react-icons/fa6";

type Props = {};

const MyBook = (props: Props) => {
    return (
        <div id="wrapper" className="w-full relative">
            {/* Header */}
            <header className="w-full px-4 py-10 text-center prose prose-invert prose-lg max-w-none bg-primary">
                <h2 className="">Buku Saya</h2>
            </header>

            {/* Second Header */}
            <div className="w-full relative">
                {/* Content */}
                <section className="w-full max-w-screen-lg mx-auto p-4">
                    {/* Book Cards */}
                    <div className="w-full flex flex-col justify-stretch items-stretch overflow-auto gap-y-4">
                        {[...Array(12).keys()].map((i) => (
                            <a
                                href={"/detail/" + i}
                                className="w-full relative"
                            >
                                <div className="flex items-center flex-nowrap bg-gray-200 gap-x-4 p-2 rounded-md hover:brightness-105 shadow-md transition-all">
                                    <div className="w-full max-w-[120px] h-auto relative rounded-md">
                                        {/* Image */}
                                        <img
                                            src="/asset/images/cover-buku.jpeg"
                                            alt=""
                                            className="block w-full h-auto rounded-md aspect-[3/4] object-cover object-center overflow-hidden"
                                        />
                                    </div>
                                    <div className="py-2 prose leading-3">
                                        <p className="font-bold">
                                            Harry Potter X Series
                                        </p>
                                        <p className="">
                                            Dipinjam pada <i>01 Januari 2024</i>
                                        </p>
                                    </div>
                                </div>
                            </a>
                        ))}
                    </div>
                </section>
            </div>

            <Footer />
        </div>
    );
};

export default MyBook;
