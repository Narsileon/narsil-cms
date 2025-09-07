import * as React from "react";
import { cn } from "@narsil-cms/lib/utils";
import { SidebarContext } from "./sidebar-context";
import type { SidebarContextProps } from "./sidebar-context";

type SidebarProviderProps = React.ComponentProps<"div"> & {
  cookieMaxAge?: number;
  cookieName?: string;
  defaultOpen?: boolean;
  iconWidth?: string;
  isMobile?: boolean;
  keyboardShortcut?: string;
  mobileWidth?: string;
  open?: boolean;
  width?: string;
  onOpenChange?: (open: boolean) => void;
};

function SidebarProvider({
  children,
  className,
  cookieMaxAge = 60 * 60 * 24 * 7,
  cookieName = "sidebar_state",
  defaultOpen = true,
  iconWidth = "3.25rem",
  isMobile = false,
  keyboardShortcut = "b",
  mobileWidth = "18rem",
  onOpenChange: setOpenProp,
  open: openProp,
  style,
  width = "14rem",
  ...props
}: SidebarProviderProps) {
  const [_open, _setOpen] = React.useState(defaultOpen);
  const [openMobile, setOpenMobile] = React.useState(false);

  const open = openProp ?? _open;

  const setOpen = React.useCallback(
    (value: boolean | ((value: boolean) => boolean)) => {
      const openState = typeof value === "function" ? value(open) : value;
      if (setOpenProp) {
        setOpenProp(openState);
      } else {
        _setOpen(openState);
      }

      document.cookie = `${cookieName}=${openState}; path=/; max-age=${cookieMaxAge}`;
    },
    [setOpenProp, open],
  );

  const toggleSidebar = React.useCallback(() => {
    return isMobile ? setOpenMobile((open) => !open) : setOpen((open) => !open);
  }, [isMobile, setOpen, setOpenMobile]);

  React.useEffect(() => {
    const handleKeyDown = (e: KeyboardEvent) => {
      if (e.key === keyboardShortcut && (e.metaKey || e.ctrlKey)) {
        e.preventDefault();

        toggleSidebar();
      }
    };

    window.addEventListener("keydown", handleKeyDown);

    return () => {
      return window.removeEventListener("keydown", handleKeyDown);
    };
  }, [toggleSidebar]);

  const state = open ? "expanded" : "collapsed";

  const contextValue = React.useMemo<SidebarContextProps>(
    () => ({
      isMobile: isMobile,
      mobileWidth: mobileWidth,
      open: open,
      openMobile: openMobile,
      state: state,
      setOpen: setOpen,
      setOpenMobile: setOpenMobile,
      toggleSidebar: toggleSidebar,
    }),
    [
      isMobile,
      mobileWidth,
      open,
      openMobile,
      state,
      setOpen,
      setOpenMobile,
      toggleSidebar,
    ],
  );

  return (
    <SidebarContext.Provider value={contextValue}>
      <div
        data-slot="sidebar-wrapper"
        className={cn(
          "group/sidebar-wrapper has-data-[variant=inset]:bg-sidebar flex min-h-svh w-full",
          className,
        )}
        style={
          {
            "--sidebar-width": width,
            "--sidebar-width-icon": iconWidth,
            ...style,
          } as React.CSSProperties
        }
        {...props}
      >
        {children}
      </div>
    </SidebarContext.Provider>
  );
}

export default SidebarProvider;
