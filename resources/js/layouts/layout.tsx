import { AppSidebar } from "@/components/app/sidebar";
import { Avatar, AvatarFallback } from "@/components/ui/avatar";
import { Link, usePage } from "@inertiajs/react";
import { Separator } from "@/components/ui/separator";
import { toast } from "sonner";
import { useEffect } from "react";
import { useTranslationsStore } from "@/stores/translations-store";
import ThemeToggle from "@/components/theme/theme-toggle";
import type { GlobalProps } from "@/types/global";
import {
  Breadcrumb,
  BreadcrumbItem,
  BreadcrumbLink,
  BreadcrumbList,
  BreadcrumbPage,
  BreadcrumbSeparator,
} from "@/components/ui/breadcrumb";
import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuTrigger,
} from "@/components/ui/dropdown-menu";
import {
  SidebarInset,
  SidebarProvider,
  SidebarTrigger,
} from "@/components/ui/sidebar";

type LayoutProps = {
  children: React.ReactNode;
};

function Layout({ children }: LayoutProps) {
  const translationStore = useTranslationsStore();

  const shared = usePage<GlobalProps>().props.shared;

  const { locale, redirect, translations } = shared ?? {};
  const { error, success } = redirect ?? {};

  useEffect(() => {
    translationStore.setLocale(locale);
    translationStore.setTranslations(translations);
  }, [locale, translations]);

  useEffect(() => {
    if (success) {
      toast.success(success);
    } else if (error) {
      toast.error(error);
    }
  }, [success, error]);

  return (
    <SidebarProvider>
      <AppSidebar />
      <SidebarInset>
        <header className="bg-background sticky top-0 flex h-12 shrink-0 items-center gap-2 border-b pr-4 pl-3">
          <SidebarTrigger />
          <Separator orientation="vertical" className="mr-2 h-4" />
          <Breadcrumb className="grow">
            <BreadcrumbList>
              <BreadcrumbItem className="hidden md:block">
                <BreadcrumbLink asChild>
                  <Link href="#">Building Your Application</Link>
                </BreadcrumbLink>
              </BreadcrumbItem>
              <BreadcrumbSeparator className="hidden md:block" />
              <BreadcrumbItem>
                <BreadcrumbPage>Data Fetching</BreadcrumbPage>
              </BreadcrumbItem>
            </BreadcrumbList>
          </Breadcrumb>
          <ThemeToggle />
          <DropdownMenu>
            <DropdownMenuTrigger asChild={true}>
              <Avatar>
                <AvatarFallback>FL</AvatarFallback>
              </Avatar>
            </DropdownMenuTrigger>
            <DropdownMenuContent align="end">User Menu</DropdownMenuContent>
          </DropdownMenu>
        </header>
        <div className="p-5">{children}</div>
      </SidebarInset>
    </SidebarProvider>
  );
}

export default Layout;
