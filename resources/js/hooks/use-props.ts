import { usePage } from "@inertiajs/react";
import { type Theme } from "@narsil-cms/stores/theme-store";
import type { MenuItem } from "@narsil-cms/types";
import { isEmpty } from "lodash-es";

export type GlobalProps = {
  auth: AuthProps;
  description: string;
  locale: string;
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

export function useAuth() {
  const { auth } = usePage<GlobalProps>().props;

  return isEmpty(auth) ? null : auth;
}

export function useLocalization() {
  return usePage<GlobalProps>().props.localization ?? {};
}

export function useLocale() {
  const locale = usePage<GlobalProps>().props.locale ?? "en";

  return { locale };
}

export function useNavigation() {
  return usePage<GlobalProps>().props.navigation ?? {};
}

export function useProps() {
  const { props } = usePage<GlobalProps>();

  return props;
}

export function useRedirect() {
  return usePage<GlobalProps>().props.redirect ?? {};
}
