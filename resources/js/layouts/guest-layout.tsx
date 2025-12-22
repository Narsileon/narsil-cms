import { Button, Container, Logo, ThemeToggleGroup, Toaster, Tooltip } from "@narsil-cms/blocks";
import { BackgroundRoot } from "@narsil-cms/components/background";
import BackgroundPaper from "@narsil-cms/components/background/background-paper";
import {
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuRoot,
  DropdownMenuSeparator,
  DropdownMenuTrigger,
} from "@narsil-cms/components/dropdown-menu";
import { useLocalization } from "@narsil-cms/components/localization";
import { ModalRenderer } from "@narsil-cms/components/modal";
import { type GlobalProps } from "@narsil-cms/hooks/use-props";
import { groupBy } from "lodash-es";
import { useRef } from "react";
import { Fragment } from "react/jsx-runtime";

type GuestLayoutProps = {
  children: React.ReactNode & {
    props: GlobalProps;
  };
};

function GuestLayout({ children }: GuestLayoutProps) {
  const { trans } = useLocalization();

  const mainRef = useRef<HTMLDivElement>(null);

  const { navigation } = children?.props;

  const groupedMenu = groupBy(navigation?.userMenu, (item) => item.group ?? "default");

  return (
    <>
      <header className="sticky top-0 z-10 h-13 border-b bg-sidebar shadow">
        <Container className="flex items-center justify-between gap-4">
          <Logo />
          <DropdownMenuRoot>
            <Tooltip tooltip={trans("accessibility.toggle_user_menu")}>
              <DropdownMenuTrigger asChild={true}>
                <Button icon="menu" size="icon" variant="ghost" />
              </DropdownMenuTrigger>
            </Tooltip>
            <DropdownMenuContent align="end">
              {Object.entries(groupedMenu).map(([group, items], groupIndex) => {
                return (
                  <Fragment key={group}>
                    {groupIndex > 0 && <DropdownMenuSeparator />}
                    {items.map((item, index) => {
                      return (
                        <DropdownMenuItem asChild={true} key={index}>
                          <Button
                            icon={item.icon}
                            linkProps={{
                              href: item.href,
                              method: item.method,
                              modal: item.modal,
                            }}
                            size="sm"
                            variant="ghost"
                          >
                            {item.label}
                          </Button>
                        </DropdownMenuItem>
                      );
                    })}
                  </Fragment>
                );
              })}
              <DropdownMenuSeparator />
              <ThemeToggleGroup className="w-full" />
            </DropdownMenuContent>
          </DropdownMenuRoot>
        </Container>
      </header>
      <main ref={mainRef} className="relative min-h-[calc(100vh-3.25rem)] overflow-hidden">
        <BackgroundRoot className="filter-[url(#paper)]">
          <BackgroundPaper />
        </BackgroundRoot>
        <ModalRenderer container={mainRef.current} />
        {children}
        <Toaster />
      </main>
    </>
  );
}

export default GuestLayout;
