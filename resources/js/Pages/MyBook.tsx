import Footer from "@/Components/Footer";
import React from "react";
import { FaStar } from "react-icons/fa6";

type Props = {
    auth?: any;
    loans?: any;
};

const MyBook = ({ auth, loans }: Props) => {
    console.log(loans);

    return (
        <div id="wrapper" className="w-full relative">
            {/* Header */}
            <header className="w-full px-4 py-16 text-center prose prose-invert prose-lg max-w-none bg-primary">
                <h2 className="">Buku Saya</h2>
            </header>

            {/* Second Header */}
            <div className="w-full relative">
                {/* Content */}
                <section className="w-full max-w-screen-lg mx-auto p-4">
                    {/* Book Cards */}
                    <div className="w-full flex flex-col justify-stretch items-stretch overflow-auto gap-y-4">
                        {loans.map((data: object, i: number) => {
                            return (
                                <a
                                    href={"/peminjaman/" + data.id}
                                    className="flex-1 w-full relative prose max-w-none"
                                >
                                    <div className="flex items-center flex-nowrap bg-gray-200 gap-x-4 p-2 rounded-md hover:brightness-105 shadow-md transition-all">
                                        <div className="w-full max-w-[120px] h-auto relative rounded-md">
                                            {/* Image */}
                                            <img
                                                src={
                                                    "/" +
                                                    data.code_book.book.cover
                                                }
                                                alt=""
                                                className="block w-full h-auto m-0 rounded-md aspect-[3/4] object-cover object-center overflow-hidden"
                                            />
                                        </div>
                                        <div className="py-2">
                                            <p className="font-bold m-0">
                                                {data.code_book.book.title}
                                            </p>
                                            <p className="m-0">
                                                Di publikasikan pada{" "}
                                                {
                                                    data.code_book.book
                                                        .publish_date
                                                }
                                            </p>
                                            <p className="">{/* {data.} */}</p>
                                        </div>
                                    </div>
                                </a>
                            );
                        })}
                    </div>
                </section>
            </div>

            <Footer />
        </div>
    );
};

export default MyBook;
