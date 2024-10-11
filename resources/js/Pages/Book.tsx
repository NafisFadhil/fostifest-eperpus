import GeneralLayout from "@/Layouts/GeneralLayout";
import SubPageLayout from "@/Layouts/SubPageLayout";
import React from "react";
import { FaStar } from "react-icons/fa6";

type Props = {};

const Book = (props: Props) => {
    return (
        <SubPageLayout>
            <div className="w-full">
                {/* Header */}
                <div id="background" className="size-full relative text-white">
                    <div className="absolute -z-[1] size-full bg-primary">
                        <img
                            src="/asset/images/cover-buku.jpeg"
                            alt=""
                            className="block size-full object-cover object-center opacity-50 blur-lg shadow-inner"
                        />
                    </div>

                    {/* Book Cover */}
                    <div className="size-full flex flex-col justify-center items-center mx-auto lg:max-w-screen-md pt-16 pb-10 px-5 gap-4">
                        {/* Image */}
                        <div className="flex-1 max-w-[220px]">
                            <img
                                src="/asset/images/cover-buku.jpeg"
                                alt=""
                                className="block w-[180px] h-auto aspect-auto rounded-md shadow-lg shadow-black/50 ml-auto"
                            />
                        </div>
                        {/* Title */}
                        <div className="flex-1 flex flex-col gap-2 text-center leading-4">
                            <p className="text-lg"> My Jaspier June </p>
                            <p className="text-sm opacity-75">
                                By Jaspier June
                            </p>
                            <div className="flex justify-center items-center gap-1">
                                <FaStar size={14} className="text-yellow-400" />
                                <FaStar size={14} className="text-yellow-400" />
                                <FaStar size={14} className="text-yellow-400" />
                                <FaStar size={14} className="text-yellow-400" />
                                <FaStar size={14} className="text-yellow-400" />
                                <span className="pl-2 text-xs opacity-75">
                                    (5.0)
                                </span>
                            </div>
                            <div className="flex flex-row flex-wrap justify-center items-center gap-2 text-xs">
                                <span className="bg-white/10 rounded-full px-4 py-1">
                                    Action
                                </span>
                                <span className="bg-white/10 rounded-full px-4 py-1">
                                    Adventure
                                </span>
                                <span className="bg-white/10 rounded-full px-4 py-1">
                                    Romance
                                </span>
                            </div>
                            {/* <a className="flex-1 max-w-max rounded-full bg-secondary px-4 py-3 mt-2 text-nowrap cursor-pointer hover:opacity-75 transition">
                                Pinjam Sekarang
                            </a> */}
                        </div>
                    </div>
                </div>

                {/* Content */}
                <main className="relative w-full max-w-screen-lg mx-auto px-4">
                    <div id="content" className="w-full max-w-none prose">
                        {/* Synopsis */}
                        <section className="w-full">
                            <h3 className="">Sinopsis</h3>
                            <p className="">
                                Lorem ipsum dolor, sit amet consectetur
                                adipisicing elit. Nostrum iure, non error illo
                                corporis facilis id recusandae veritatis minus
                                sit, aspernatur, asperiores odio quas aperiam
                                laborum porro quos velit sequi omnis. Nostrum
                                vitae commodi fuga, aspernatur distinctio vero
                                reprehenderit ipsam dolorem voluptas sequi ex
                                enim minus deserunt, animi tenetur quasi est
                                voluptate qui ut saepe? Sequi ut nemo totam,
                                sapiente commodi, impedit cupiditate dolores
                                natus consectetur minima consequuntur fuga illum
                                officiis. Esse quisquam ipsa dolores?
                            </p>
                        </section>

                        <section className="w-full">
                            <a
                                href=""
                                className="block w-full rounded-full shadow px-4 py-2 text-center bg-primary text-white not-prose hover:opacity-75 transition"
                            >
                                Pinjam Sekarang
                            </a>
                        </section>
                    </div>
                </main>
            </div>
        </SubPageLayout>
    );
};

export default Book;
