import { Toaster } from "@/components/ui/toaster";
import AppLogo from "@/components/app/app-logo";
import UserMenu from "@/components/app/user/menu";

type GuestLayoutProps = {
  children: React.ReactNode;
};

function GuestLayout({ children }: GuestLayoutProps) {
  return (
    <>
      <header className="bg-background sticky top-0 flex h-12 shrink-0 items-center justify-between gap-2 border-b pr-4 pl-3">
        <AppLogo />
        <UserMenu />
      </header>
      <div className="relative min-h-[calc(100vh-3rem)] p-5">
        {children}
        <Toaster />
      </div>
    </>
  );
}

export default GuestLayout;
