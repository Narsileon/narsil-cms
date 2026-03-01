import { usePage } from "@inertiajs/react";
import type { MenuItem } from "@narsil-cms/types";
import { type Theme } from "@narsil-ui/stores/theme-store";

export type GlobalProps = {
  auth: AuthProps;
  description: string;
  navigation: {
    breadcrumb: {
      href: string;
      label: string;
    }[];
    sidebar: MenuItem[];
    userMenu: MenuItem[];
  };
  redirect: RedirectProps;
  session: SessionProps;
  title: string;
  translations: Record<string, string>;
  url: string;
};

type AuthProps = {
  avatar: string | null;
  email: string;
  first_name: string | undefined | null;
  full_name: string | undefined | null;
  last_name: string | undefined | null;
  two_factor_confirmed_at: string | null;
};

type SessionProps = {
  color: string;
  locale: string;
  radius: number;
  theme: Theme;
};

type RedirectProps = {
  data?: Record<string, unknown>;
  error: string;
  info: string;
  success: string;
  warning: string;
};

export function useNavigation() {
  return usePage<GlobalProps>().props.navigation ?? {};
}
