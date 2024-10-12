import { Link, Head } from "@inertiajs/react";
import { PageProps } from "@/types";
import {
    FaMagnifyingGlass,
    FaStar,
    FaHouse,
    FaUser,
    FaBookmark,
} from "react-icons/fa6";
import GeneralLayout from "@/Layouts/GeneralLayout";
import HeaderHomePage from "@/Components/HeaderHomePage";
import Footer from "@/Components/Footer";

export default function Home() {
    return (
        <GeneralLayout>
            <Head title="Home" />

            <div
                id="wrapper"
                className="w-full relative overflow-x-hidden overflow-y-auto"
            >
                <HeaderHomePage />

                <div className="w-full px-4 pt-16 pb-10 text-center prose prose-invert prose-lg max-w-none bg-primary">
                    <h2 className=""> Selamat Datang </h2>
                </div>

                <main className="w-full flex flex-col justify-stretch gap-y-8 px-4 py-8">
                    <section className="w-full max-w-screen-lg mx-auto flex flex-col gap-2">
                        <div className="w-full flex items-center">
                            Daftar Buku
                            <div className="flex-1 leading-5">
                                <h2 className="font-bold font-sans"></h2>
                                <p className="text-sm">
                                    Lorem ipsum dolor sit amet.
                                </p>
                            </div>
                        </div>
                        <div className="w-full p-2 flex flex-row flex-wrap justify-start items-stretch overflow-auto scrollbar-hide gap-y-8 gap-x-4">
                            {[...Array(12).keys()].map((i) => (
                                <a
                                    href={"/detail/" + i}
                                    className="flex-1 flex-shrink flex-grow-0 basis-[125px] hover:scale-105 transition-all"
                                >
                                    <div className="w-full max-w-[220px] h-auto relative rounded-md">
                                        {/* Image */}
                                        <img
                                            src="/asset/images/cover-buku.jpeg"
                                            alt=""
                                            className="block w-[180px] h-auto rounded-md ml-auto aspect-[3/4] object-cover object-center overflow-hidden"
                                        />

                                        <div className="absolute bottom-0 left-0 bg-white shadow text-xs flex flex-row items-center flex-nowrap leading-3 p-1 text-yellow-500 gap-1">
                                            <FaStar
                                                size={10}
                                                className="p-0 m-0"
                                            />
                                            <span className="-mb-1"> 5 </span>
                                        </div>
                                    </div>
                                    <div className="pb-2 pt-0">
                                        <span className="text-xs rounded-md px-1 bg-green-300 text-white">
                                            Ready
                                        </span>
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
        </GeneralLayout>
    );
}
