import { createContext, useContext } from "react";

export type SidebarContextProps = {
  isMobile: boolean;
  mobileWidth: string;
  open: boolean;
  openMobile: boolean;
  state: "expanded" | "collapsed";
  setOpen: (open: boolean) => void;
  setOpenMobile: (open: boolean) => void;
  toggleSidebar: () => void;
};

export const SidebarContext = createContext<SidebarContextProps | null>(null);

function useSidebar() {
  const context = useContext(SidebarContext);

  if (!context) {
    throw new Error("useSidebar must be used within a SidebarProvider.");
  }

  return context;
}

export default useSidebar;
