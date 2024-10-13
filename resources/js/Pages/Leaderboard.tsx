import Footer from "@/Components/Footer";
import React from "react";
import { FaCrown } from "react-icons/fa6";

type Props = {
    leaderboard: any;
};

const Leaderboard = ({ leaderboard }: Props) => {
    return (
        <div>
            <div className="w-full h-[100dvh] flex justify-center items-center relative p-4 bg-primary">
                <div className="w-full max-w-screen-lg mx-auto py-10">
                    {/* Title Hero */}
                    <div className="w-full flex items-center justify-center">
                        <FaCrown size={30} className="text-white" />
                        <h1 className="text-white text-2xl font-bold ml-2">
                            Leaderboard
                        </h1>
                    </div>

                    {/* Urutan */}
                    <div className="flex flex-col items-stretch justify-center py-10 text-center">
                        {leaderboard.map((data: any, i: number) => {
                            console.log(data);

                            return (
                                <div
                                    key={i}
                                    className="w-full flex flex-col gap-8 items-center justify-center py-4 px-4"
                                >
                                    <div className="flex items-center justify-center gap-4 flex-nowrap">
                                        <h1 className="text-3xl font-bold rounded-full border border-white text-white size-20 flex justify-center items-center">
                                            1
                                        </h1>
                                        <div className="text-left flex-1">
                                            <h1 className="text-white text-xl font-bold">
                                                {data.user.name}
                                            </h1>
                                            <h1 className="text-white text-md font-semibold">
                                                Peringkat{" "}
                                                <strong>
                                                    {data.level.name}
                                                </strong>
                                            </h1>
                                        </div>
                                        <div className="text-yellow-500 max-w-max font-bold text-2xl">
                                            {data.poin}
                                        </div>
                                    </div>
                                    <div className="flex items-center justify-center gap-4 flex-nowrap">
                                        <h1 className="text-3xl font-bold rounded-full border border-white text-white size-20 flex justify-center items-center">
                                            2
                                        </h1>
                                        <div className="text-left flex-1">
                                            <h1 className="text-white text-xl font-bold">
                                                {data.user.name}
                                            </h1>
                                            <h1 className="text-white text-md font-semibold">
                                                Peringkat{" "}
                                                <strong>
                                                    {data.level.name}
                                                </strong>
                                            </h1>
                                        </div>
                                        <div className="text-yellow-500 max-w-max font-bold text-2xl">
                                            {data.poin}
                                        </div>
                                    </div>
                                    <div className="flex items-center justify-center gap-4 flex-nowrap">
                                        <h1 className="text-3xl font-bold rounded-full border border-white text-white size-20 flex justify-center items-center">
                                            3
                                        </h1>
                                        <div className="text-left flex-1">
                                            <h1 className="text-white text-xl font-bold">
                                                {data.user.name}
                                            </h1>
                                            <h1 className="text-white text-md font-semibold">
                                                Peringkat{" "}
                                                <strong>
                                                    {data.level.name}
                                                </strong>
                                            </h1>
                                        </div>
                                        <div className="text-yellow-500 max-w-max font-bold text-2xl">
                                            {data.poin}
                                        </div>
                                    </div>
                                </div>
                            );
                        })}
                    </div>
                </div>
            </div>

            <Footer />
        </div>
    );
};

export default Leaderboard;
