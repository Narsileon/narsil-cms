import { Button } from "@narsil-cms/blocks/button";
import { Container } from "@narsil-cms/blocks/container";
import { Logo } from "@narsil-cms/blocks/logo";
import { Toaster } from "@narsil-cms/blocks/toaster";
import { ThemeToggleGroup } from "@narsil-cms/blocks/toggle-group";
import { Tooltip } from "@narsil-cms/blocks/tooltip";
import { BackgroundRoot } from "@narsil-cms/components/background";
import BackgroundPaper from "@narsil-cms/components/background/background-paper";
import {
  DropdownMenuItem,
  DropdownMenuPopup,
  DropdownMenuPortal,
  DropdownMenuPositioner,
  DropdownMenuRoot,
  DropdownMenuSeparator,
  DropdownMenuTrigger,
} from "@narsil-cms/components/dropdown-menu";
import { useLocalization } from "@narsil-cms/components/localization";
import { ModalRenderer } from "@narsil-cms/components/modal";
import { type GlobalProps } from "@narsil-cms/hooks/use-props";
import { groupBy } from "lodash-es";
import { Fragment, type ReactNode, useRef } from "react";

type GuestLayoutProps = {
  children: ReactNode & {
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
              <DropdownMenuTrigger render={<Button icon="menu" size="icon" variant="ghost" />} />
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
