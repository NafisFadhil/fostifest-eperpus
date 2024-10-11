import Footer from "@/Components/Footer";
import HeaderSubPage from "@/Components/HeaderSubPage";
import React from "react";
import GeneralLayout from "./GeneralLayout";

type Props = {
    children: React.ReactNode;
};

function SubPageLayout({ children }: PageProps<Props>) {
    return (
        <GeneralLayout>
            <HeaderSubPage />
            {children}
        </GeneralLayout>
    );
}

export default SubPageLayout;
