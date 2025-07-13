import { Container } from "@/components/ui/container";
import { ModalRenderer } from "@/components/ui/modal";
import { Toaster } from "@/components/ui/toaster";
import { useRef } from "react";
import AppLogo from "@/components/app/app-logo";
import UserMenu from "@/components/app/user/menu";

type GuestLayoutProps = {
  children: React.ReactNode;
};

function GuestLayout({ children }: GuestLayoutProps) {
  const mainRef = useRef<HTMLDivElement>(null);

  return (
    <>
      <header className="bg-background sticky top-0 z-10 h-12 border-b">
        <Container className="flex items-center justify-between gap-4">
          <AppLogo />
          <UserMenu />
        </Container>
      </header>
      <main ref={mainRef} className="relative min-h-[calc(100vh-3rem)]">
        <ModalRenderer container={mainRef.current} />
        {children}
        <Toaster />
      </main>
    </>
  );
}

export default GuestLayout;
