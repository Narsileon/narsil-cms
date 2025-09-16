import { useRef } from "react";

import { Logo, Toaster, UserMenu } from "@narsil-cms/blocks";
import { ContainerRoot } from "@narsil-cms/components/container";
import { ModalRenderer } from "@narsil-cms/components/modal";

type GuestLayoutProps = {
  children: React.ReactNode;
};

function GuestLayout({ children }: GuestLayoutProps) {
  const mainRef = useRef<HTMLDivElement>(null);

  return (
    <>
      <header className="sticky top-0 z-10 h-13 border-b bg-background">
        <ContainerRoot className="flex items-center justify-between gap-4">
          <Logo />
          <UserMenu />
        </ContainerRoot>
      </header>
      <main ref={mainRef} className="relative min-h-[calc(100vh-3.25rem)]">
        <ModalRenderer container={mainRef.current} />
        {children}
        <Toaster />
      </main>
    </>
  );
}

export default GuestLayout;
