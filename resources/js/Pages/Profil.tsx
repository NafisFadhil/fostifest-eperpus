import Footer from "@/Components/Footer";
import GeneralLayout from "@/Layouts/GeneralLayout";
import SubPageLayout from "@/Layouts/SubPageLayout";
import React from "react";
import { FaAngleLeft, FaStar } from "react-icons/fa6";

type Props = {};

const Profil = (props: Props) => {
    return (
        <div id="wrapper" className="w-full relative">
            {/* Header */}
            <header className="w-full fixed z-[2] top-0 flex items-center px-4 py-3">
                {/* Container */}
                <div className="mx-auto max-w-screen-lg w-full">
                    {/* Title */}
                    <h1 className="text-lg font-bold -mb-1 text-white">
                        Profil
                    </h1>
                </div>
            </header>

            {/* Second Header */}
            <div className="w-full relative">
                {/* Header */}
                <div className="w-full text-white text-center relative bg-primary/50">
                    <img
                        src="/storage/avatar/avatar1.jpeg"
                        alt=""
                        className="object-center object-cover overflow-hidden size-full absolute top-0 left-0 right-0 bottom-0 z-[-1] blur-2xl opacity-75"
                    />

                    <div className="flex flex-col items-center justify-center w-full mx-auto gap-4 px-6 pt-16 pb-10">
                        {/* Avatar */}
                        <div className="flex-1 max-w-[120px]">
                            <img
                                src="/storage/avatar/avatar1.jpeg"
                                alt=""
                                className="aspect-square object-center object-cover overflow-hidden rounded-full h-[120px] w-[120px] shadow-md shadow-black/50 mx-auto"
                            />
                        </div>
                        {/* Detail */}
                        <div className="flex flex-col">
                            <p className="text-lg">Jaspier</p>
                        </div>
                    </div>
                </div>

                {/* Content */}
                <main className="w-full mt-10 flex flex-col justify-stretch gap-y-8 px-2 py-8">
                    {/* History */}
                    <section className="hidden w-full max-w-screen-lg mx-auto flex flex-col gap-2 p-4 bg-[#EEE]">
                        <div className="w-full flex items-center">
                            <div className="flex-1 leading-5">
                                <h2 className="font-bold font-sans">
                                    Rekomendasi Buku
                                </h2>
                                <p className="text-sm">
                                    Lorem ipsum dolor sit amet.
                                </p>
                            </div>
                            <a
                                href=""
                                className="text-center text-xs leading-3 text-primary font-bold hover:bg-black/5 rounded-full p-2 transition"
                            >
                                Lihat <br /> Semua
                            </a>
                        </div>
                        <div className="w-full flex flex-row items-stretch overflow-auto scrollbar-hide rounded justify-start gap-x-3">
                            {[...Array(12).keys()].map((i) => (
                                <a
                                    href={"/detail/" + i}
                                    className="min-w-[150px] hover:scale-105 transition-all"
                                >
                                    <div className="w-full max-w-[220px] h-auto relative rounded-md">
                                        {/* Image */}
                                        <img
                                            src="/asset/images/cover-buku.jpeg"
                                            alt=""
                                            className="block w-[180px] h-auto rounded-md ml-auto aspect-[3/4] object-cover object-center overflow-hidden"
                                        />

                                        <div className="absolute bottom-0 left-0 bg-white shadow text-xs flex flex-row items-center flex-nowrap leading-3 p-1 text-yellow-600">
                                            <FaStar
                                                size={10}
                                                className="p-0 m-0"
                                            />
                                            <span> 4.8 </span>
                                        </div>
                                    </div>
                                    <div className="py-2">
                                        <p className="text-xs leading-4">
                                            Judul Buku: Harry Potter X Series
                                        </p>
                                    </div>
                                </a>
                            ))}
                        </div>
                    </section>
                </main>
            </div>

            <Footer />
        </div>
    );
};

export default Profil;
