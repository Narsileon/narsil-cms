import { Container } from "@narsil-cms/components/ui/container";
import { Logo } from "@narsil-cms/blocks";
import { ModalRenderer } from "@narsil-cms/components/ui/modal";
import { Toaster } from "@narsil-cms/components/ui/toaster";
import { useRef } from "react";
import UserMenu from "@narsil-cms/components/user/menu";

type GuestLayoutProps = {
  children: React.ReactNode;
};

function GuestLayout({ children }: GuestLayoutProps) {
  const mainRef = useRef<HTMLDivElement>(null);

  return (
    <>
      <header className="bg-background sticky top-0 z-10 h-13 border-b">
        <Container className="flex items-center justify-between gap-4">
          <Logo />
          <UserMenu />
        </Container>
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
