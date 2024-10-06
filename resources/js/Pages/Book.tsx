import GeneralLayout from "@/Layouts/GeneralLayout";
import React from "react";

type Props = {};

const Book = (props: Props) => {
    return (
        <GeneralLayout>
            <div className="w-full">
                <div
                    id="background"
                    className="w-full h-[50dvh] overflow-hidden relative flex justify-center items-center"
                >
                    {/* Background Fade */}
                    <div
                        className="absolute -z-10"
                        style={{
                            boxShadow: "0 0 1000px 0 white inset",
                        }}
                    >
                        <img
                            src="/asset/images/cover-buku.jpeg"
                            alt=""
                            className="block object-cover object-center w-full h-full brightness-75 saturate-50 opacity-15"
                        />
                    </div>

                    {/* Book Cover */}
                    {/* Image */}
                    <div className="flex flex-col items-center gap-2">
                        <img
                            src="/asset/images/cover-buku.jpeg"
                            alt=""
                            className="block object-cover object-center w-[150px] h-auto aspect-auto"
                        />
                        {/* Title */}
                        <div className="text-center leading-3">
                            <p className="text-lg"> My Jaspier June </p>
                            <p className="text-sm opacity-75">
                                {" "}
                                November 2025{" "}
                            </p>
                        </div>
                    </div>
                </div>

                <main
                    className="relative w-full bg-white px-4 py-4"
                    style={{
                        boxShadow: "0 -10px 15px rgb(0 0 0 / 10%)",
                    }}
                >
                    <div id="content" className="">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit.
                        Minus maxime perspiciatis amet molestiae, vel dolorem
                        quas voluptate minima magni neque tenetur blanditiis a
                        soluta deleniti optio atque beatae ducimus quod, iste
                        dolor. Sunt, dolorem odit! Doloribus, quidem. Eos iusto
                        dolorum voluptas, nulla ducimus dignissimos incidunt!
                        Labore, provident laboriosam deserunt, odit voluptas
                        autem minus sit quia, saepe temporibus molestias ipsam!
                        Laborum aperiam velit consectetur temporibus corporis
                        laudantium odio deserunt omnis minima blanditiis
                        similique earum, hic tempora quia. Autem eveniet
                        possimus repudiandae sequi temporibus fugit corrupti!
                        Repellendus, architecto in reprehenderit nisi ad aut
                        nulla dolor cumque, magni fuga nihil dicta,
                        exercitationem ratione.
                    </div>
                </main>
            </div>
        </GeneralLayout>
    );
};

export default Book;
