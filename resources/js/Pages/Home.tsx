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
import BookItemHome from "@/Components/BookItem/BookItemHome";

type Props = {
    allData: any;
};

export default function Home({ allData }: Props) {
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
                        <div className="w-full flex items-center flex-col">
                            <p className="text-xl font-bold text-primary">
                                {" "}
                                Daftar Buku{" "}
                            </p>
                            <div className="flex-1 leading-5">
                                <h2 className="font-bold font-sans"></h2>
                                <p className="text-sm">
                                    Temukan buku favoritmu
                                </p>
                            </div>
                        </div>
                        <div className="w-full p-2 flex flex-row flex-wrap justify-start items-stretch overflow-auto scrollbar-hide gap-y-8 gap-x-4">
                            {allData.map((data: object, i: number) => {
                                return <BookItemHome data={data} />;
                            })}
                        </div>
                    </section>
                </main>
            </div>
        </GeneralLayout>
    );
}
