import { Link } from "@inertiajs/react";
import { Sidebar } from "@narsil-cms/blocks/sidebar";
import { ThemeToggleGroup } from "@narsil-cms/blocks/toggle-group";
import { SidebarInset, SidebarProvider, SidebarTrigger } from "@narsil-cms/components/sidebar";
import { GlobalProps } from "@narsil-cms/hooks/use-props";
import { Bookmarks } from "@narsil-ui/blocks/bookmarks";
import { AlertDialogProvider } from "@narsil-ui/components/alert-dialog";
import { AvatarFallback, AvatarImage, AvatarRoot } from "@narsil-ui/components/avatar";
import { Breadcrumb } from "@narsil-ui/components/breadcrumb";
import { Button } from "@narsil-ui/components/button";
import {
  DropdownMenuItem,
  DropdownMenuPopup,
  DropdownMenuPortal,
  DropdownMenuPositioner,
  DropdownMenuRoot,
  DropdownMenuSeparator,
  DropdownMenuTrigger,
} from "@narsil-ui/components/dropdown-menu";
import { Icon } from "@narsil-ui/components/icon";
import { ModalLink, ModalRenderer } from "@narsil-ui/components/modal";
import { Separator } from "@narsil-ui/components/separator";
import { Tooltip } from "@narsil-ui/components/tooltip";
import { useTranslator } from "@narsil-ui/components/translator";
import { useMaxLg } from "@narsil-ui/hooks/use-breakpoints";
import { groupBy } from "lodash-es";
import { Fragment, type ReactNode, useRef } from "react";
import { route } from "ziggy-js";

type AuthLayoutProps = {
  children: ReactNode & {
    props: GlobalProps;
  };
};

function AuthLayout({ children }: AuthLayoutProps) {
  const { trans } = useTranslator();

  const isMobile = useMaxLg();
  const mainRef = useRef<HTMLDivElement>(null);

  const { auth, navigation } = children?.props;

  const groupedMenu = groupBy(navigation?.userMenu, (item) => item.group ?? "default");

  return (
    <AlertDialogProvider>
      <SidebarProvider isMobile={isMobile}>
        <Sidebar />
        <SidebarInset>
          <header className="sticky top-0 z-10 flex h-13 items-center gap-2 border-b bg-background pr-4 pl-2 text-foreground xl:pl-4">
            {isMobile ? (
              <>
                <SidebarTrigger />
                <Separator orientation="vertical" />
              </>
            ) : null}
            <Breadcrumb breadcrumb={navigation.breadcrumb} className="grow" />
            <Bookmarks breadcrumb={navigation.breadcrumb} />
            <DropdownMenuRoot>
              <Tooltip tooltip={trans("accessibility.toggle_user_menu")}>
                <DropdownMenuTrigger>
                  <AvatarRoot>
                    {auth.avatar ? (
                      <AvatarImage src={auth.avatar} alt={auth.full_name ?? "User"} />
                    ) : null}
                    <AvatarFallback>
                      <Icon name="user" />
                    </AvatarFallback>
                  </AvatarRoot>
                </DropdownMenuTrigger>
              </Tooltip>
              <DropdownMenuPortal>
                <DropdownMenuPositioner align="end">
                  <DropdownMenuPopup>
                    {Object.entries(groupedMenu).map(([group, items], groupIndex) => {
                      return (
                        <Fragment key={group}>
                          {groupIndex > 0 && <DropdownMenuSeparator />}
                          {items.map((item, index) => {
                            return (
                              <DropdownMenuItem
                                key={index}
                                render={
                                  <Button
                                    size="sm"
                                    variant="ghost"
                                    render={
                                      item.modal ? (
                                        <ModalLink
                                          href={route(item.route, item.parameters)}
                                          method={item.method}
                                        >
                                          <Icon name={item.icon} />
                                          {item.label}
                                        </ModalLink>
                                      ) : (
                                        <Link
                                          href={route(item.route, item.parameters)}
                                          method={item.method}
                                        >
                                          <Icon name={item.icon} />
                                          {item.label}
                                        </Link>
                                      )
                                    }
                                  />
                                }
                              />
                            );
                          })}
                        </Fragment>
                      );
                    })}
                    <DropdownMenuSeparator />
                    <ThemeToggleGroup className="w-full" />
                  </DropdownMenuPopup>
                </DropdownMenuPositioner>
              </DropdownMenuPortal>
            </DropdownMenuRoot>
          </header>
          <div ref={mainRef} className="relative h-[calc(100vh-3.25rem)] overflow-y-auto">
            <ModalRenderer container={mainRef.current} />
            {children}
          </div>
        </SidebarInset>
      </SidebarProvider>
    </AlertDialogProvider>
  );
}

export default AuthLayout;
