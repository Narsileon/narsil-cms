import { Toaster } from "@/components/ui/toaster";
import AppLogo from "@/components/app/app-logo";
import UserMenu from "@/components/app/user/menu";
import { Container } from "@/components/ui/container";

type GuestLayoutProps = {
  children: React.ReactNode;
};

function GuestLayout({ children }: GuestLayoutProps) {
  return (
    <>
      <header className="bg-background sticky top-0 h-12 border-b">
        <Container className="flex items-center justify-between gap-4">
          <AppLogo />
          <UserMenu />
        </Container>
      </header>
      <main className="relative h-[calc(100vh-3rem)] min-h-fit">
        {children}
        <Toaster />
      </main>
    </>
  );
}

export default GuestLayout;
